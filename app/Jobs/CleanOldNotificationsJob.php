<?php

namespace App\Jobs;

use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanOldNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Nombre de jours avant suppression
     */
    public int $daysToKeep;

    /**
     * Nombre de tentatives
     */
    public int $tries = 1;

    /**
     * Timeout en secondes
     */
    public int $timeout = 300;

    /**
     * Créer une nouvelle instance du job
     */
    public function __construct(int $daysToKeep = 30)
    {
        $this->daysToKeep = $daysToKeep;
        $this->onQueue('maintenance');
    }

    /**
     * Exécuter le job
     */
    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays($this->daysToKeep);

        try {
            // Supprimer les notifications lues anciennes
            $deletedRead = UserNotification::where('is_read', true)
                ->where('read_at', '<', $cutoffDate)
                ->delete();

            // Supprimer les notifications non lues très anciennes (60 jours)
            $oldCutoffDate = Carbon::now()->subDays($this->daysToKeep * 2);
            $deletedUnread = UserNotification::where('is_read', false)
                ->where('created_at', '<', $oldCutoffDate)
                ->delete();

            $totalDeleted = $deletedRead + $deletedUnread;

            Log::info('Old notifications cleaned', [
                'deleted_read' => $deletedRead,
                'deleted_unread' => $deletedUnread,
                'total_deleted' => $totalDeleted,
                'days_to_keep' => $this->daysToKeep,
                'cutoff_date' => $cutoffDate->toDateString(),
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to clean old notifications', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Gérer l'échec du job
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Notification cleanup job failed', [
            'error' => $exception->getMessage(),
        ]);
    }

    /**
     * Tags pour le monitoring
     */
    public function tags(): array
    {
        return ['cleanup', 'notifications'];
    }
}