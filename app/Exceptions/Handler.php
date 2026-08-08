<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return parent::render($request, $exception);
        }

        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            
            // Vérifier si la vue personnalisée existe
            if (view()->exists("errors.{$statusCode}")) {
                $titles = [
                    401 => 'Session expirée',
                    403 => 'Accès interdit',
                    404 => 'Page non trouvée',
                    419 => 'Session expirée',
                    429 => 'Trop de requêtes',
                    500 => 'Erreur serveur',
                    503 => 'Site en maintenance',
                ];

                $messages = [
                    401 => 'Votre session a expiré. Veuillez vous reconnecter.',
                    403 => "Vous n'avez pas l'autorisation d'accéder à cette page.",
                    404 => "Désolé, la page que vous cherchez n'existe pas.",
                    419 => 'Votre session a expiré. Veuillez rafraîchir la page.',
                    429 => 'Trop de requêtes. Veuillez patienter.',
                    500 => 'Une erreur est survenue. Notre équipe a été notifiée.',
                    503 => 'Nous effectuons une maintenance. Revenez dans quelques instants.',
                ];

                return response()->view("errors.{$statusCode}", [
                    'title' => $titles[$statusCode] ?? 'Erreur',
                    'message' => $messages[$statusCode] ?? 'Une erreur est survenue.',
                ], $statusCode);
            }
        }

        return parent::render($request, $exception);
    }
}