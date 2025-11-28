<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\CleanOldNotificationsJob;
use App\Jobs\UpdateUserStatisticsJob;

/*
|--------------------------------------------------------------------------
| Console Routes (Laravel 12)
|--------------------------------------------------------------------------
|
| Depuis Laravel 11, le scheduler est défini directement dans routes/console.php
| Plus besoin de app/Console/Kernel.php
|
*/

// ============================================
// Jobs de Maintenance
// ============================================

// Nettoyer les anciennes notifications (tous les jours à 2h du matin)
Schedule::job(new CleanOldNotificationsJob(30))
    ->daily()
    ->at('02:00')
    ->name('clean-old-notifications')
    ->onOneServer()
    ->withoutOverlapping()
    ->description('Nettoyer les notifications de plus de 30 jours');

// Mettre à jour les statistiques de tous les utilisateurs (tous les jours à 3h du matin)
Schedule::job(new UpdateUserStatisticsJob())
    ->daily()
    ->at('03:00')
    ->name('update-all-user-statistics')
    ->onOneServer()
    ->withoutOverlapping()
    ->description('Recalculer les statistiques de tous les utilisateurs');

// ============================================
// Jobs de Monitoring
// ============================================

// Nettoyer les jobs échoués de plus de 7 jours (toutes les semaines)
Schedule::command('queue:prune-failed --hours=168')
    ->weekly()
    ->sundays()
    ->at('01:00')
    ->name('prune-failed-jobs')
    ->description('Supprimer les jobs échoués de plus de 7 jours');

// Nettoyer les jobs complétés de plus de 24h (tous les jours)
Schedule::command('queue:prune-batches --hours=24')
    ->daily()
    ->at('01:30')
    ->name('prune-batches')
    ->description('Supprimer les batches de plus de 24h');

// ============================================
// Commandes personnalisées
// ============================================

// Exemple: Commande pour tester les jobs
// Schedule::command('jobs:test investment')
//     ->everyFiveMinutes()
//     ->name('test-investment-jobs');

// ============================================
// Jobs de Backup (optionnel)
// ============================================

// Backup de la base de données (tous les jours à 4h du matin)
// Nécessite: composer require spatie/laravel-backup
// Schedule::command('backup:run --only-db')
//     ->daily()
//     ->at('04:00')
//     ->name('database-backup')
//     ->description('Backup quotidien de la base de données');

// ============================================
// Jobs de Logs (optionnel)
// ============================================

// Nettoyer les anciens logs (toutes les semaines)
// Note: Vous devrez créer cette commande ou utiliser un package
// Schedule::command('log:clear')
//     ->weekly()
//     ->sundays()
//     ->at('04:00')
//     ->name('clear-old-logs')
//     ->description('Nettoyer les logs de plus de 30 jours');