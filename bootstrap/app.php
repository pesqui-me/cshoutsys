<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // ============================================
        // Middleware Globaux
        // ============================================
        
        $middleware->append([
            \App\Http\Middleware\CheckMaintenanceMode::class,
        ]);
        
        // ============================================
        // Middleware du groupe 'web'
        // ============================================
        
        $middleware->web(append: [
            \App\Http\Middleware\CheckUserActive::class,
            \App\Http\Middleware\LogUserActivity::class,
        ]);
        
        // ============================================
        // Alias de Middleware
        // ============================================
        
        $middleware->alias([
            // Middleware d'authentification
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            
            // Middleware Spatie Permission
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            
            // Middleware personnalisés CASH OUT
            'check.role' => \App\Http\Middleware\CheckRole::class,
            'check.investment.ownership' => \App\Http\Middleware\CheckInvestmentOwnership::class,
            'check.withdrawal.ownership' => \App\Http\Middleware\CheckWithdrawalOwnership::class,
            'check.transaction.ownership' => \App\Http\Middleware\CheckTransactionOwnership::class,
            'check.ticket.ownership' => \App\Http\Middleware\CheckTicketOwnership::class,
            'check.user.active' => \App\Http\Middleware\CheckUserActive::class,
            'check.maintenance' => \App\Http\Middleware\CheckMaintenanceMode::class,
            'log.activity' => \App\Http\Middleware\LogUserActivity::class,
        ]);
        
        // ============================================
        // Middleware de Groupe Personnalisés
        // ============================================
        
        // Groupe pour les routes user
        $middleware->group('user.protected', [
            'auth',
            \App\Http\Middleware\CheckUserActive::class,
        ]);
        
        // Groupe pour les routes admin
        $middleware->group('admin', [
            'auth',
            \App\Http\Middleware\CheckUserActive::class,
            \Spatie\Permission\Middleware\RoleMiddleware::class.':super-admin|admin',
        ]);
        
        // ============================================
        // Middleware de Priorité
        // ============================================
        
        $middleware->priority([
            \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Auth\Middleware\Authorize::class,
            
            // Nos middleware personnalisés en priorité
            \App\Http\Middleware\CheckMaintenanceMode::class,
            \App\Http\Middleware\CheckUserActive::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // ============================================
        // Gestion des Exceptions
        // ============================================
        
        // 403 - Accès refusé
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e) {
            return response()->view('errors.403', [
                'message' => $e->getMessage() ?: 'Accès refusé',
            ], 403);
        });
        
        // 404 - Page non trouvée
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return response()->view('errors.404', [], 404);
        });
        
        // 419 - Token CSRF expiré
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            if ($e->getStatusCode() === 419) {
                return back()->with('error', 'Votre session a expiré. Veuillez réessayer.');
            }
        });
        
        // 500 - Erreur serveur (en production seulement)
        if (app()->environment('production')) {
            $exceptions->render(function (\Throwable $e) {
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    return null;
                }
                
                logger()->error('Server Error', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                
                return response()->view('errors.500', [], 500);
            });
        }
        
    })->create();