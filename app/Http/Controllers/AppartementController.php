<?php

namespace App\Http\Controllers;

use App\Mail\ContacteProprietaireAppartementMail;
use App\Models\Appartement;
use App\Models\Entreprise;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\ImageModerationService;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;

class AppartementController extends Controller
{
    private function imageModerationService(): ImageModerationService
    {
        return app(ImageModerationService::class);
    }

    private function rejectNonRealEstateImages(array $files): void
    {
        if (empty($files)) {
            return;
        }

        $moderator = $this->imageModerationService();

        if (! $moderator->isConfigured()) {
            Log::info('[ImageModeration] Clé Anthropic absente, modération serveur ignorée.');
            return;
        }

        $result = $moderator->moderate($files);

        if (!($result['rejected'] ?? false)) {
            return;
        }

        throw ValidationException::withMessages([
            'images' => [
                $result['reason'] ?? 'Certaines images ne semblent pas liées à l\'immobilier.',
            ],
        ]);
    }

    //
    /**
     * Formulaire deposer une annonce
    */
    public function appartement()
    {
      
        $entreprise = Entreprise::where('user_id', auth()->id())->firstOrFail();

        // Gratuit si jamais utilisé
        $isFirstTime = !$entreprise->free_used; 
          
        return view('appartements.create', compact('isFirstTime'));
    }


    /**
      * l'enregistremen des annonces  
    */ 
    public function appartementStore(Request $request)
    {
        try {
            $request->validate([
                'type'        => 'required|in:Maison,Appartement,Bureaux,Boutique,Terrain',
                'categorie'   => 'required|in:louer,vendre',
                'duree'       => 'nullable|string',
                'departement' => 'required|string',
                'quartier'    => 'required|string',
                'prix'        => 'required',
                'images'      => 'required|array|min:1',
                'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:10240',
                'video'       => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:102400',
                'latitude'    => 'nullable|numeric',
                'longitude'   => 'nullable|numeric',
            ]);

            $entreprise = Entreprise::where('user_id', auth()->id())->first();
            if (!$entreprise) {
                return response()->json(['status' => 500, 'message' => 'Entreprise introuvable']);
            }

            /* ── Images ── */
            $this->rejectNonRealEstateImages($request->file('images'));

            $images = [];
            foreach ($request->file('images') as $file) {
                $name = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/appartement'), $name);
                $images[] = 'images/appartement/' . $name;
            }

            /* ── Vidéo ── */
            $videoPath = null;
            if ($request->hasFile('video')) {
                $vid  = $request->file('video');
                $name = uniqid('vid_') . '.' . $vid->getClientOriginalExtension();
                $vid->move(public_path('images/appartement/videos'), $name);
                $videoPath = 'images/appartement/videos/' . $name;
            }

            $prix      = (float) preg_replace('/\s+/', '', $request->prix);
            $type      = $request->type;
            $isTerrain = $type === 'Terrain';
            $isResid   = in_array($type, ['Maison', 'Appartement']);
            $isBureau  = $type === 'Bureaux';
            $isBoutique= $type === 'Boutique';

            /* ── Surfaces (selon les vrais champs envoyés par la vue) ── */
            if ($isTerrain) {
                $surface = (float) ($request->surfaceTerrain ?? $request->surface ?? 0);
                // NB: la vue envoie le champ "surface" pour le terrain (id="surfaceTerrain"
                // mais name="surface"), donc $request->surface suffit en pratique.
            } elseif ($isBoutique) {
                $surface = (float) ($request->surface_boutique ?? 0);
            } elseif ($isBureau) {
                $surface = (float) ($request->surface_bureau ?? 0);
            } else {
                // Maison / Appartement : la vue calcule déjà le total dans "surface"
                $surface = (float) ($request->surface ?? 0);
            }

            /* ── Pièces ── */
            $nombreSalon     = $isResid ? (int) ($request->nombreSalon     ?? 0) : 0;
            $nombreCuisine   = $isResid ? (int) ($request->nombreCuisine   ?? 0) : 0;
            $nombreChambre   = $isResid ? (int) ($request->nombreChambre   ?? 0) : 0;
            $nombreSalleBain = $isResid ? (int) ($request->nombreSalleBain ?? 0) : 0;
            $nombrePieces    = $isResid
                ? ($nombreSalon + $nombreCuisine + $nombreChambre + $nombreSalleBain)
                : (int) ($request->nombrePiecesBureaux ?? 0);

            /* ── Compteurs (eau / élec) — ces noms correspondent déjà à la vue ── */
            $compteurEau  = $request->compteur_eau_val  ?? 'Non';
            $compteurElec = $request->compteur_elec_val ?? 'Non';

            /* ── Équipements — lecture selon le type réellement affiché dans la vue ──
            Chaque checkbox de la vue porte un name différent par type
            (ex: clime_c pour résidentiel, clime_b pour bureau, clime_bt pour boutique).
            $request->input('champ', 'Non') renvoie la valeur cochée (ex: "Climatiseur")
            si présente, ou 'Non' si la checkbox n'a pas été cochée / n'existe pas. */
            if ($isTerrain) {
                $clime = 'Non'; $wifi = 'Non'; $securite = 'Non';
                $terasse = 'Non'; $cuisineEq = 'Non'; $entretien = 'Non inclus';
                $brasseur = 'Non'; $salleConf = 'Non'; $vitrine = 'Non';
                $collocation = 'Non'; $packing = 'Non'; $sanitaire = 'Non'; $proprioVit = 'Non';
            } elseif ($isResid) {
                $clime      = $request->input('clime_c', 'Non');
                $wifi       = $request->input('wifi_c', 'Non');
                $securite   = $request->input('securite_c', 'Non');
                $terasse    = $request->input('terasse_c', 'Non');
                $cuisineEq  = $request->input('cuisine_eq', 'Non');
                $entretien  = $request->input('entretien_c', 'Non inclus');
                $brasseur   = $request->input('brasseur', 'Non');
                $salleConf  = 'Non';
                $vitrine    = 'Non';
                $collocation = $request->collocation ?? 'Non';
                $packing     = $request->packing     ?? 'Non';
                $sanitaire   = $request->sanitaire    ?? 'Non';
                $proprioVit  = $request->proprio_vit  ?? 'Non';
            } elseif ($isBureau) {
                $clime      = $request->input('clime_b', 'Non');
                $wifi       = $request->input('wifi_b', 'Non');
                $securite   = $request->input('securite_b', 'Non');
                $terasse    = 'Non';
                $cuisineEq  = 'Non';
                $entretien  = 'Non inclus';
                $brasseur   = $request->input('brasseur_b', 'Non');
                $salleConf  = $request->input('salle_conf', 'Non');
                $vitrine    = 'Non';
                $collocation = 'Non';
                $packing     = $request->packing_bureaux   ?? 'Non';
                $sanitaire   = $request->sanitaire_bureaux  ?? 'Non';
                $proprioVit  = 'Non';
            } else { // Boutique
                $clime      = $request->input('clime_bt', 'Non');
                $wifi       = 'Non';
                $securite   = $request->input('securite_bt', 'Non');
                $terasse    = 'Non';
                $cuisineEq  = 'Non';
                $entretien  = 'Non inclus';
                $brasseur   = $request->input('brasseur_bt', 'Non');
                $salleConf  = 'Non';
                $vitrine    = $request->input('vitrine_bt', 'Non');
                $collocation = 'Non';
                $packing     = $request->filled('parking_bt') ? 'Oui' : 'Non';
                $sanitaire   = $request->filled('toilette_bt') ? 'Oui' : 'Non';
                $proprioVit  = 'Non';
            }

            /* ── Terrain — champs spécifiques (alignés avec la vue) ── */
    
            $autresCarac     = $isTerrain ? ($request->autres_caracteristiques_terrain ?? null) : null;
            $terrainLargeur  = $isTerrain ? (float) ($request->terrain_largeur  ?? 0) : null;
            $terrainLongueur = $isTerrain ? (float) ($request->terrain_longueur ?? 0) : null;

            $latitude  = $request->filled('latitude')  ? (float) $request->latitude  : null;
            $longitude = $request->filled('longitude') ? (float) $request->longitude : null;

            $appartement = Appartement::create([
                'type'             => $type,
                'categorie'        => $request->categorie,
                'duree'            => $request->duree ?? '7 Jours',

                'departement'      => $request->departement,
                'commune'          => $request->commune,
                'quartier'         => $request->quartier,
                'latitude'         => $latitude,
                'longitude'        => $longitude,

                'surface'          => $surface,
                'surface_salon'    => (float) ($request->surface_salon   ?? 0),
                'surface_cuisine'  => (float) ($request->surface_cuisine ?? 0),
                'surface_chambre'  => (float) ($request->surface_chambre ?? 0),
                'surface_sdb'      => (float) ($request->surface_sdb     ?? 0),
                'surface_bureau'   => $isBureau ? $surface : null,
                'surface_boutique' => $isBoutique ? $surface : null,

                // Terrain
                'terrain_largeur'  => $terrainLargeur,
                'terrain_longueur' => $terrainLongueur,
                'titre_foncier'    => $request->titre_foncier ?? null,
                'autres_caracteristiques_terrain' => $autresCarac,

                'nombrePieces'     => $nombrePieces,
                'nombreSalon'      => $nombreSalon,
                'nombreCuisine'    => $nombreCuisine,
                'nombreChambre'    => $nombreChambre,
                'nombreSalleBain'  => $nombreSalleBain,

                'disponible_date'  => $isTerrain ? null : ($request->disponible_date ?: null),
                'compteur_eau'     => $compteurEau,
                'compteur_elec'    => $compteurElec,

                'meuble'           => $request->meuble ?? 'Non meublé',
                'collocation'      => $collocation,
                'packing'          => $packing,
                'sanitaire'        => $sanitaire,
                'proprio_vit'      => $proprioVit,

                'clime'            => $clime,
                'wifi'             => $wifi,
                'securite'         => $securite,
                'terasse'          => $terasse,
                'cuisine'          => $cuisineEq,
                'entretien'        => $entretien,
                'brasseur'         => $brasseur,
                'salle_conf'       => $salleConf,
                'vitrine'          => $vitrine,

                'prix'             => $prix,
                'negociable'       => $request->negociable ?? 'Non',
                'caution'          => $isTerrain ? '0' : ($request->caution ?? '0'),

                'description' => $request->description ?? $request->autres_caracteristiques_terrain ?? '',
                'images'           => implode('|', $images),
                'video'            => $videoPath,

                'transactionId'    => $request->transactionId ?? 'T-'.time(),
                'entreprise_id'    => $entreprise->id,
                // statut = true uniquement si on demande explicitement l'activation
                'statut'           => $request->boolean('activate', false),
            ]);

            // Si l'annonce est publiée immédiatement (ex: première annonce gratuite)
            if ($request->boolean('activate', false)) {
                $entreprise->update(['free_used' => true]);
            }

            return response()->json(['status' => 200, 'appartement_id' => $appartement->id]);

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 422,
                'message' => 'Données invalides',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('[AppartementStore] Exception', [
                'message' => $e->getMessage(),
            ]);
            return response()->json([
                'status'  => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function AnnonceAll()
    {
        $today = Carbon::now();

        // Désactiver les annonces expirées
        Appartement::where('statut', 1)->get()->each(function($app) use ($today) {
            $daysPassed = $today->diffInDays(Carbon::parse($app->created_at));
            if (
                $app->duree == "7 Jours" && $daysPassed > 7
            ) {
                $app->update(['statut' => 0]);
            }
        });

        // Paginate ici — pas get()
        $appartements = Appartement::where('statut', 1)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('appartements.index', compact('appartements'));
    }

    /**
     * Détail appartement
     */
    public function appartementDetail($id)
    {
        // Récupération de l'annonce avec l'entreprise
        $appartements = Appartement::with('entreprise')->findOrFail($id);

        // Incrémenter les vues sauf pour le propriétaire
        if (
            !auth()->check() ||
            auth()->id() !== optional($appartements->entreprise)->user_id
        ) {
            $appartements->increment('views');
        }

        // Récupérer 2 quartiers aléatoires différents
        $lieux = Appartement::where('statut', 1)
            ->where('id', '!=', $id)
            ->whereNotNull('quartier')
            ->distinct()
            ->inRandomOrder()
            ->limit(2)
            ->pluck('quartier');

        // Récupérer les annonces similaires
        $appartementSimilaires = Appartement::where('statut', 1)
        ->where('id', '!=', $id)

        // Même type
        ->where('type', $appartements->type)

        // Même ville/quartier
        ->where('quartier', $appartements->quartier)

        // Prix proche
        ->whereBetween('prix', [
            $appartements->prix - 50000,
            $appartements->prix + 50000
        ])

        ->inRandomOrder()
        ->take(4)
        ->get();

        return view('appartements.detail', compact(
            'appartements',
            'appartementSimilaires'
        ));
    }

    /**
     * Rechercher un appartement
    */
    public function searchAppartement(Request $request)
    {
        try {

            if ($request->prix_min && $request->prix_max && $request->prix_min > $request->prix_max) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Le prix minimum ne peut pas être supérieur au prix maximum.');
            }

            $appartements = Appartement::query()
                ->where('statut', 1)  // ← ajoute ça pour ne montrer que les actives
                ->when($request->type,        fn ($q) => $q->where('type', $request->type))
                ->when($request->categorie,   fn ($q) => $q->where('categorie', $request->categorie))
                ->when($request->departement, fn ($q) => $q->where('departement', $request->departement))
                ->when($request->commune,     fn ($q) => $q->where('commune', $request->commune))
                ->when($request->quartier,    fn ($q) => $q->where('quartier', 'like', "%{$request->quartier}%"))
                ->when($request->prix_min,    fn ($q) => $q->where('prix', '>=', $request->prix_min))
                ->when($request->prix_max,    fn ($q) => $q->where('prix', '<=', $request->prix_max))
                ->latest()
                ->paginate(9)          // ← remplace get()
                ->withQueryString();   // ← garde les filtres dans les liens de pagination

            return view('appartements.index', compact('appartements'));

        } catch (\Throwable $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    /**
     * Envoyer un mail par le formulaire de contact
    */
    public function mailProprietaire(Request $request){

        $request->validate([
            'nom'=>'required',
            'telephone'=>'required',
            'message'=>'required',
            'email'=>'required'

        ], [
            'nom.required'=>' Votre nom est requis',
            'message.required'=>'Le message est requis',
            'telephone.required'=>'Le numéro de téléphone est requis',
            'email.required'=>'Votre email est requis',
            
        ]);
        $entreprise= $request->entreprise;
        $nom= $request->nom;
        $telephone = $request->telephone;
        $message = $request->message;
        $email= $request->email;

        Mail::to($entreprise)->send(new ContacteProprietaireAppartementMail($nom, $telephone, $email, $message));

        return back()->with('success', 'Votre message a bien été transmis .');
    }

    /**
     * Formulaire pour modifier une annonce
    */
    public function update(Appartement $appartement){
        return view('appartements.update', compact('appartement'));
    }


/**
 * Mise à jour d'une annonce immobilière.
 *
 * Gère tous les nouveaux champs :
 *  - Géolocalisation (latitude / longitude)
 *  - Pièces détaillées (nombreSalon, nombreChambre, nombreSalleBain)
 *  - Sanitaire, proprio_vit, compteur_perso
 *  - Vidéo (ajout / conservation / suppression)
 *  - Photos 10 Mo
 *
 * Route : PUT /appartement/{id}
 * Nom   : appartement.update
 */
public function appartementUpdate(Request $request, $id)
{
    try {
        $appartement = Appartement::findOrFail($id);

        /* ── Autorisation ── */
        $entreprise = Entreprise::where('user_id', auth()->id())->first();
        if (!$entreprise || $appartement->entreprise_id !== $entreprise->id) {
            return response()->json(['status' => 403, 'message' => 'Non autorisé'], 403);
        }

        /* ── Validation ── */
        $request->validate([
            'type'         => 'required|in:Maison,Appartement,Bureaux,Boutique,Terrain',
            'categorie'    => 'required|in:louer,vendre',
            'departement'  => 'required|string',
            'quartier'     => 'required|string|min:2',
            'prix'         => 'required',
            'description'  => 'required|string|min:10',
            'images.*'     => 'image|mimes:jpg,jpeg,png,webp|max:10240', // 10 Mo
            'video'        => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:102400',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
        ]);

        /* ── Prix ── */
        $prix = (float) preg_replace('/\s+/', '', $request->prix);

        /* ── Surface ── */
        $surface = $request->type === 'Boutique'
            ? (float) ($request->surface_boutique ?? 0)
            : (float) ($request->surface ?? 0);

        /* ── Pièces ── */
        $isResid = in_array($request->type, ['Maison', 'Appartement']);

        $nombreSalon     = $isResid ? (int) ($request->nombreSalon     ?? 0) : 0;
        $nombreChambre   = $isResid ? (int) ($request->nombreChambre   ?? 0) : 0;
        $nombreSalleBain = $isResid ? (int) ($request->nombreSalleBain ?? 0) : 0;

        $nombrePieces = $isResid
            ? ($nombreSalon + $nombreChambre + $nombreSalleBain)
            : (int) ($request->nombrePiecesBureaux ?? $request->nombrePieces ?? 1);

        /* ── Équipements ── */
        $clime     = $request->clime     ?? 'Non';
        $wifi      = in_array($request->type, ['Boutique'])
                     ? 'Non'
                     : ($request->wifi ?? 'Non');
        $securite  = $request->securite  ?? 'Non';
        $terasse   = in_array($request->type, ['Bureaux', 'Boutique'])
                     ? 'Non'
                     : ($request->terasse ?? 'Non');
        $cuisine   = in_array($request->type, ['Bureaux', 'Boutique'])
                     ? 'Non'
                     : ($request->cuisine ?? 'Non');
        $entretien = in_array($request->type, ['Bureaux', 'Boutique'])
                     ? 'Non inclus'
                     : ($request->entretien ?? 'Non inclus');

        /* ── Options résidentielles ── */
        $meuble       = in_array($request->type, ['Bureaux', 'Boutique'])
                        ? 'Non meublé'
                        : ($request->meuble ?? 'Non meublé');
        $collocation  = in_array($request->type, ['Bureaux', 'Boutique'])
                        ? 'Non'
                        : ($request->collocation ?? 'Non');
        $packing      = $request->packing ?? $request->packing_bureaux ?? 'Non';

        /* Nouveaux champs */
        $sanitaire    = $isResid
                        ? ($request->sanitaire         ?? 'Non')
                        : ($request->sanitaire_bureaux ?? 'Non');
        $proprioVit   = $isResid
                        ? ($request->proprio_vit       ?? 'Non')
                        : 'Non';
        $compteurPerso = $isResid
                        ? ($request->compteur_perso    ?? 'Non')
                        : ($request->compteur_bureaux  ?? 'Non');

        /* ── Disponibilité ── */
        $dispoImmed = $request->boolean('dispo_immed');
        $dispoDate  = $dispoImmed ? null : ($request->disponible_date ?: null);

        /* ── Géolocalisation ── */
        $latitude  = $request->filled('latitude')  ? (float) $request->latitude  : null;
        $longitude = $request->filled('longitude') ? (float) $request->longitude : null;

        /* ── Gestion photos ── */
        // 1) Photos conservées (non supprimées par l'utilisateur)
        $keptImages = array_values(array_filter(
            explode('|', $request->images_to_keep ?? '')
        ));

        // 2) Nouvelles photos uploadées
        $newImages = [];
        if ($request->hasFile('images')) {
            $this->rejectNonRealEstateImages($request->file('images'));
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = uniqid('img_') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/appartement'), $name);
                $newImages[] = 'images/appartement/' . $name;
            }
        }

        $allImages = array_merge($keptImages, $newImages);
        $imagesStr = implode('|', array_filter($allImages));

        // Si aucune image → garder les anciennes (sécurité)
        if (empty($imagesStr)) {
            $imagesStr = $appartement->images;
        }

        /* ── Gestion vidéo ── */
        $videoPath = $appartement->video; // conserver par défaut

        // video_to_keep=0 → l'utilisateur a cliqué "Supprimer" sur la vidéo existante
        if ($request->input('video_to_keep') === '0') {
            // Supprimer physiquement l'ancienne vidéo si elle existe
            if ($appartement->video && file_exists(public_path($appartement->video))) {
                @unlink(public_path($appartement->video));
            }
            $videoPath = null;
        }

        // Une nouvelle vidéo a été envoyée → elle remplace l'ancienne
        if ($request->hasFile('video')) {
            // Supprimer l'ancienne
            if ($appartement->video && file_exists(public_path($appartement->video))) {
                @unlink(public_path($appartement->video));
            }
            $vid  = $request->file('video');
            $name = uniqid('vid_') . '.' . $vid->getClientOriginalExtension();
            $vid->move(public_path('images/appartement/videos'), $name);
            $videoPath = 'images/appartement/videos/' . $name;
        }

        /* ── Mise à jour en BD ── */
        $appartement->update([
            // Type & catégorie
            'type'              => $request->type,
            'categorie'         => $request->categorie,
            'duree'             => $request->duree,

            // Adresse
            'departement'       => $request->departement,
            'commune'           => $request->commune,
            'quartier'          => $request->quartier,
            'latitude'          => $latitude,
            'longitude'         => $longitude,

            // Caractéristiques
            'surface'           => $surface,
            'nombrePieces'      => $nombrePieces,
            'nombreSalon'       => $nombreSalon,
            'nombreChambre'     => $nombreChambre,
            'nombreSalleBain'   => $nombreSalleBain,

            // Disponibilité
            'disponible_date'   => $dispoDate,
            'dispo_immed'       => $dispoImmed,

            // Options
            'meuble'            => $meuble,
            'collocation'       => $collocation,
            'packing'           => $packing,
            'sanitaire'         => $sanitaire,
            'proprio_vit'       => $proprioVit,
            'compteur_perso'    => $compteurPerso,

            // Équipements
            'clime'             => $clime,
            'wifi'              => $wifi,
            'securite'          => $securite,
            'terasse'           => $terasse,
            'cuisine'           => $cuisine,
            'entretien'         => $entretien,

            // Prix
            'prix'              => $prix,
            'negociable'        => $request->negociable ?? 'Non',
            'caution'           => $request->caution    ?? '0',

            // Contenu
            'description'       => $request->description,
            'images'            => $imagesStr,
            'video'             => $videoPath,
        ]);

        return response()->json(['status' => 200]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status'  => 422,
            'message' => 'Données invalides',
            'errors'  => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        Log::error('[AppartementUpdate] Exception', [
            'appartement_id' => $id,
            'message' => $e->getMessage(),
        ]);
        return response()->json([
            'status'  => 500,
            'message' => $e->getMessage(),
        ]);
    }
}

    /**
     * Supprimer une annonce
     */
    public function destroy($id)
    {
        $appartement = Appartement::findOrFail($id);
       

        // 👉 Suppression des images si nécessaire
        if ($appartement->image && file_exists(public_path('images/appartements/'.$appartement->image))) {
            unlink(public_path('images/appartements/'.$appartement->image));
        }

        $appartement->delete();

        return redirect()->back()->with('success', 'Appartement supprimé avec succès.');
    }

    /**
     * Activer/Desactiver une annonce
     */
    // public function toggleStatut($id)
    // {
    //     $appartement = Appartement::findOrFail($id);

    //     // Inverser le statut
    //     $appartement->statut = !$appartement->statut;
    //     $appartement->save();

    //     return back()->with(
    //         'success',
    //         $appartement->statut 
    //             ? 'Annonce réactivée avec succès.'
    //             : 'Annonce désactivée avec succès.'
    //     );
    // }

 
    /**
     * Activer ou désactiver l'annonce
     */
 
    /**
     * Activer ou désactiver l'annonce
     */
    public function toggleStatut($id)
    {
        $appartement = Appartement::findOrFail($id);

        // Si on désactive simplement
        if ($appartement->statut) {
            $appartement->statut = false;
            $appartement->save();
            return back()->with('success', 'Annonce désactivée avec succès.');
        }

        // Sinon on veut réactiver → vérifier la durée
        $dureeTexte = $appartement->duree; // "30 Jours" ou "90 Jours"
        $duree = (int) filter_var($dureeTexte, FILTER_SANITIZE_NUMBER_INT);

        $dateCreation = Carbon::parse($appartement->created_at);
        $dateJour = Carbon::now();
        $joursEcoules = $dateCreation->diffInDays($dateJour);

        if ($joursEcoules > $duree) {
            // Paiement requis
            $montant = $duree == 30 ? 2000 : 5000;

            return back()->with([
                'paiement_required' => true,
                'appartement_id' => $id,
                'montant' => $montant,
                'duree' => $dureeTexte
            ]);
        }

        // Réactivation simple si durée non dépassée
        $appartement->statut = true;
        $appartement->save();

        return back()->with('success', 'Annonce réactivée avec succès.');
    }

    /**
     * Après paiement réussi
    */
    public function paiementSuccess(Request $request,$appartementId)
    {
        if (!$appartementId) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 400, 'message' => 'Paiement non associé'], 400);
            }
            return redirect()->back()->with('error', 'Session expirée, paiement non associé.');
        }

        $appartement = Appartement::find($appartementId);

        if (!$appartement) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 404, 'message' => 'Appartement introuvable'], 404);
            }
            return redirect()->back()->with('error', 'Appartement introuvable.');
        }

        // Si appel AJAX / POST depuis le widget, mettre à jour et envoyer un email
        $transactionId = $request->input('transactionId');
        if ($transactionId || $request->isMethod('post')) {
            $appartement->transactionId = $transactionId ?? $appartement->transactionId;
            $appartement->statut = true;
            $appartement->created_at = Carbon::now();
            $appartement->save();

            // Envoyer un mail de confirmation au propriétaire (depuis l'application)
            try {
                $entreprise = $appartement->entreprise;
                if ($entreprise && $entreprise->user && filter_var($entreprise->user->email, FILTER_VALIDATE_EMAIL)) {
                    \Illuminate\Support\Facades\Mail::to($entreprise->user->email)
                        ->send(new \App\Mail\AnnoncePayeeMail($appartement));
                }
            } catch (\Exception $e) {
                Log::error('[PaiementSuccess][Mail] Erreur envoi mail: '.$e->getMessage());
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['status' => 200, 'message' => 'Annonce activée']);
            }

            return redirect()->back()->with('success', 'Paiement effectué, annonce réactivée.');
        }

        // Fallback : redirection
        return redirect()->back()->with('success', 'Paiement traité.');
    }

    /**
 * Gère le like / dislike d'une annonce.
 * Stocke l'état en session pour éviter les doublons par visiteur.
 * Enregistre les compteurs en base dans la table appartements.
 *
 * POST /appartement/reaction
 * Body JSON : { id: int, type: "like"|"dislike" }
 * Retourne  : { likes: int, dislikes: int, reaction: "like"|"dislike"|null }
 */
public function reaction(Request $request)
{
    $request->validate([
        'id'   => 'required|integer|exists:appartements,id',
        'type' => 'required|in:like,dislike',
    ]);
 
    $id   = (int) $request->id;
    $type = $request->type;          // 'like' ou 'dislike'
 
    // Clé de session unique : "reaction_{id_annonce}"
    $sessionKey = 'reaction_' . $id;
 
    // ── Ce visiteur a-t-il déjà voté ? ──────────────────────────
    if (session()->has($sessionKey)) {
        /*
         * Déjà voté : on renvoie les compteurs actuels sans rien modifier.
         * Le front-end désactivera les boutons à la réception de success:false.
         */
        $appt = \App\Models\Appartement::findOrFail($id);
 
        return response()->json([
            'success'  => false,
            'likes'    => $appt->likes,
            'dislikes' => $appt->dislikes,
            'message'  => 'Vous avez déjà voté pour cette annonce.',
        ]);
    }
 
    // ── Premier vote : on incrémente ─────────────────────────────
    $appt = \App\Models\Appartement::findOrFail($id);
 
    if ($type === 'like') {
        $appt->increment('likes');
    } else {
        $appt->increment('dislikes');
    }
 
    // Mémoriser le vote en session (toute la durée de la session navigateur)
    session([$sessionKey => $type]);
 
    // Retourner les nouvelles valeurs fraîches
    $appt->refresh();
 
    return response()->json([
        'success'  => true,
        'likes'    => $appt->likes,
        'dislikes' => $appt->dislikes,
    ]);
}
 





}
