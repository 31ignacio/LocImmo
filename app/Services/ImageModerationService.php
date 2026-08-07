<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service de modération IA des images via Claude Vision (Anthropic).
 *
 * — Analyse chaque image uploadée.
 * — Retourne true si AU MOINS UNE image est hors-sujet immobilier.
 * — En cas d'erreur API (quota, réseau…), on laisse passer (fail-open).
 *
 * Configuration requise dans .env :
 *   ANTHROPIC_API_KEY=sk-ant-...
 */
class ImageModerationService
{
    /* ─────────────────────────────────────────────
       Constantes
    ───────────────────────────────────────────── */

    /** Endpoint messages Anthropic */
    private const API_URL = 'https://api.anthropic.com/v1/messages';

    /** Modèle Claude utilisé — claude-haiku-3-5 = le moins cher / le plus rapide */
    private const MODEL = 'claude-haiku-4-5';

    /** Taille max image en bytes avant redimensionnement base64 (5 Mo) */
    private const MAX_BYTES = 5 * 1024 * 1024;

    /** Timeout requête HTTP (secondes) */
    private const TIMEOUT = 20;

    /** Mots-clés immobiliers acceptés dans la réponse IA */
    private const REAL_ESTATE_KEYWORDS = [
        'immobilier', 'bâtiment', 'maison', 'appartement', 'bureau',
        'boutique', 'façade', 'intérieur', 'pièce', 'chambre', 'salon',
        'cuisine', 'salle de bain', 'couloir', 'escalier', 'terrasse',
        'jardin', 'piscine', 'garage', 'immeuble', 'construction',
        'architecture', 'property', 'building', 'room', 'house', 'apartment',
        'real estate', 'office', 'shop', 'interior', 'exterior', 'logement',
        'résidence', 'villa', 'studio', 'loft', 'duplex', 'commerce',
        'entrepôt', 'hangar', 'terrain', 'lot', 'foncier', 'mur', 'sol',
        'plafond', 'fenêtre', 'porte', 'toit', 'balcon', 'véranda',
    ];

    public function isConfigured(): bool
    {
        return filled(config('services.anthropic.key'));
    }

    public function getConfigurationWarning(): string
    {
        return 'Modération IA inactive : configurez ANTHROPIC_API_KEY dans le fichier .env.';
    }

    /* ─────────────────────────────────────────────
       Méthode principale publique
    ───────────────────────────────────────────── */

    /**
     * Vérifie si au moins une image de la liste n'est pas liée à l'immobilier.
     *
     * @param  UploadedFile[]  $files   Tableau de fichiers uploadés
     * @return array {
     *   bool   $rejected        true si modération déclenchée
     *   string $reason          Raison lisible pour l'utilisateur
     *   array  $details         Résultats image par image
     * }
     */
    public function moderate(array $files): array
    {
        if (! $this->isConfigured()) {
            return [
                'rejected' => false,
                'reason'   => $this->getConfigurationWarning(),
                'details'  => [],
            ];
        }

        $details  = [];
        $rejected = false;
        $reason   = '';

        foreach ($files as $index => $file) {
            $result = $this->analyzeImage($file, $index + 1);
            $details[] = $result;

            if (! $result['is_real_estate']) {
                $rejected = true;
                $reason   = $result['reason'];
                // On continue pour loguer tous les résultats
            }
        }

        if ($rejected) {
            Log::warning('[ImageModeration] Annonce rejetée — image(s) hors immobilier.', [
                'details' => $details,
            ]);
        }

        return [
            'rejected' => $rejected,
            'reason'   => $reason ?: 'Images validées.',
            'details'  => $details,
        ];
    }

    /* ─────────────────────────────────────────────
       Analyse unitaire d'une image
    ───────────────────────────────────────────── */

    /**
     * Analyse une seule image via Claude Vision.
     *
     * @return array {
     *   int    $image_num
     *   bool   $is_real_estate
     *   string $reason
     *   string $raw_response
     * }
     */
    private function analyzeImage(UploadedFile $file, int $imageNum): array
    {
        try {
            /* 1. Préparer la base64 de l'image */
            $base64   = $this->fileToBase64($file);
            $mimeType = $this->getMimeType($file);

            /* 2. Prompt de modération strict */
            $prompt = <<<PROMPT
Tu es un système de modération d'images pour une plateforme immobilière au Bénin (Afrique de l'Ouest).

Ta mission : déterminer si cette image est en rapport avec l'immobilier.

Une image EST liée à l'immobilier si elle montre :
- L'extérieur d'un bâtiment (maison, appartement, bureau, boutique, villa, immeuble)
- L'intérieur d'une propriété (salon, chambre, cuisine, salle de bain, couloir, escalier, garage)
- Des espaces extérieurs d'une propriété (jardin, terrasse, piscine, cour, parking)
- Des locaux commerciaux ou professionnels (bureau, entrepôt, hangar, commerce)
- Un terrain ou une parcelle foncière
- Des matériaux de construction ou travaux sur un bien immobilier
- Un plan ou schéma d'un bien immobilier

Une image N'EST PAS liée à l'immobilier si elle montre :
- Des personnes, portraits, selfies
- De la nourriture ou boissons
- Des animaux
- Des voitures ou véhicules (sauf si garés dans un garage montré)
- Des paysages naturels sans bâtiment visible
- Du texte, affiches, publicités sans bâtiment
- Des objets du quotidien (vêtements, électroménager isolé, etc.)
- Du contenu inapproprié

Réponds UNIQUEMENT avec ce format JSON strict, rien d'autre :
{
  "is_real_estate": true ou false,
  "confidence": "high" ou "medium" ou "low",
  "description": "description courte en français de ce que tu vois (max 20 mots)",
  "reason": "explication courte en français si non immobilier (max 15 mots), sinon vide"
}
PROMPT;

            /* 3. Appel API Anthropic */
            $response = Http::timeout(self::TIMEOUT)
                ->withHeaders([
                    'x-api-key'         => config('services.anthropic.key'),
                    'anthropic-version' => '2023-06-01',
                    'Content-Type'      => 'application/json',
                ])
                ->post(self::API_URL, [
                    'model'      => config('services.anthropic.model', self::MODEL),
                    'max_tokens' => 300,
                    'messages'   => [
                        [
                            'role'    => 'user',
                            'content' => [
                                [
                                    'type'   => 'image',
                                    'source' => [
                                        'type'       => 'base64',
                                        'media_type' => $mimeType,
                                        'data'       => $base64,
                                    ],
                                ],
                                [
                                    'type' => 'text',
                                    'text' => $prompt,
                                ],
                            ],
                        ],
                    ],
                ]);

            /* 4. Parser la réponse */
            if ($response->failed()) {
                Log::error('[ImageModeration] Erreur API Anthropic', [
                    'status'  => $response->status(),
                    'body'    => $response->body(),
                    'image'   => $imageNum,
                ]);
                // Fail-open : on laisse passer si l'API échoue
                return $this->buildResult($imageNum, true, 'API indisponible — image acceptée par défaut.', '');
            }

            $rawText = $response->json('content.0.text', '');
            return $this->parseAiResponse($rawText, $imageNum);

        } catch (\Exception $e) {
            Log::error('[ImageModeration] Exception', [
                'message' => $e->getMessage(),
                'image'   => $imageNum,
            ]);
            // Fail-open
            return $this->buildResult($imageNum, true, 'Erreur interne — image acceptée par défaut.', '');
        }
    }

    /* ─────────────────────────────────────────────
       Parsing de la réponse IA
    ───────────────────────────────────────────── */

    private function parseAiResponse(string $rawText, int $imageNum): array
    {
        /* Extraction du JSON dans la réponse */
        $jsonText = $rawText;

        // Supprimer d'éventuels blocs markdown ```json ... ```
        if (preg_match('/```(?:json)?\s*([\s\S]+?)\s*```/', $rawText, $m)) {
            $jsonText = $m[1];
        }

        $data = json_decode(trim($jsonText), true);

        if (json_last_error() !== JSON_ERROR_NONE || ! isset($data['is_real_estate'])) {
            Log::warning('[ImageModeration] Réponse JSON invalide', [
                'raw'   => $rawText,
                'image' => $imageNum,
            ]);
            // Fail-open : JSON invalide → on accepte
            return $this->buildResult($imageNum, true, 'Parsing IA échoué — image acceptée.', $rawText);
        }

        $isRealEstate = (bool) $data['is_real_estate'];
        $confidence   = $data['confidence']   ?? 'low';
        $description  = $data['description']  ?? '';
        $reason       = $data['reason']       ?? '';

        /* Vérification supplémentaire par mots-clés si confiance faible */
        if (! $isRealEstate && $confidence === 'low') {
            foreach (self::REAL_ESTATE_KEYWORDS as $kw) {
                if (stripos($description . ' ' . $rawText, $kw) !== false) {
                    $isRealEstate = true;
                    break;
                }
            }
        }

        /* Construire le message de rejet lisible */
        $userReason = '';
        if (! $isRealEstate) {
            $userReason = $reason
                ? 'Image #'.$imageNum.' refusée : '.$reason
                : 'Image #'.$imageNum.' non liée à l\'immobilier ('.$description.')';
        }

        return $this->buildResult($imageNum, $isRealEstate, $userReason, $rawText, $description, $confidence);
    }

    /* ─────────────────────────────────────────────
       Helpers
    ───────────────────────────────────────────── */

    private function buildResult(
        int    $imageNum,
        bool   $isRealEstate,
        string $reason,
        string $rawResponse,
        string $description = '',
        string $confidence  = 'n/a'
    ): array {
        return [
            'image_num'      => $imageNum,
            'is_real_estate' => $isRealEstate,
            'reason'         => $reason,
            'description'    => $description,
            'confidence'     => $confidence,
            'raw_response'   => $rawResponse,
        ];
    }

    /**
     * Convertit un UploadedFile en base64.
     * Si le fichier dépasse MAX_BYTES, on le redimensionne via GD avant l'encodage.
     */
    private function fileToBase64(UploadedFile $file): string
    {
        $path = $file->getRealPath();
        $size = filesize($path);

        if ($size <= self::MAX_BYTES) {
            return base64_encode(file_get_contents($path));
        }

        /* Redimensionnement pour réduire la taille */
        try {
            $mime = $file->getMimeType();
            $img  = match ($mime) {
                'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
                'image/png'               => imagecreatefrompng($path),
                'image/webp'              => imagecreatefromwebp($path),
                default                   => imagecreatefromjpeg($path),
            };

            $w = imagesx($img);
            $h = imagesy($img);

            /* On cible 1200px max en largeur */
            $maxW  = 1200;
            $ratio = $maxW / $w;
            $newW  = (int) ($w * $ratio);
            $newH  = (int) ($h * $ratio);

            $resized = imagecreatetruecolor($newW, $newH);
            imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);

            ob_start();
            imagejpeg($resized, null, 80);
            $data = ob_get_clean();

            imagedestroy($img);
            imagedestroy($resized);

            return base64_encode($data);
        } catch (\Exception $e) {
            /* Fallback : on encode tel quel */
            return base64_encode(file_get_contents($path));
        }
    }

    /**
     * Retourne le type MIME compatible Anthropic.
     */
    private function getMimeType(UploadedFile $file): string
    {
        return match ($file->getMimeType()) {
            'image/jpeg', 'image/jpg' => 'image/jpeg',
            'image/png'               => 'image/png',
            'image/gif'               => 'image/gif',
            'image/webp'              => 'image/webp',
            default                   => 'image/jpeg',
        };
    }
}
