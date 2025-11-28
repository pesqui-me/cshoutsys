<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
Route::get('/', function () {
    return view('guest.landing.index'); // Landing page
})->name('home');

// Pages légales
Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('privacy');

// Redirect root si authentifié
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    
    // Redirection selon le rôle
    if ($user->hasRole(['super-admin', 'admin'])) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->hasRole('support')) {
        return redirect()->route('admin.support.index');
    }
    
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Routes Utilisateur (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('account')->name('user.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Account\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [\App\Http\Controllers\Account\DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/remaining-time/{investment}', [\App\Http\Controllers\Account\DashboardController::class, 'getRemainingTime'])->name('dashboard.remaining-time');
    
    // Notifications
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Account\DashboardController::class, 'markNotificationsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/{notification}/mark-read', [\App\Http\Controllers\Account\DashboardController::class, 'markNotificationRead'])->name('notifications.mark-read');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\Account\DashboardController::class, 'deleteNotification'])->name('notifications.delete');
    
    // Investissements
    Route::prefix('investments')->name('investments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Account\InvestmentController::class, 'index'])->name('index');
        Route::get('/buy-card', [\App\Http\Controllers\Account\InvestmentController::class, 'buyCard'])->name('buy-card');
        Route::post('/purchase', [\App\Http\Controllers\Account\InvestmentController::class, 'processPurchase'])->name('purchase');
        Route::get('/{investment}', [\App\Http\Controllers\Account\InvestmentController::class, 'show'])->name('show');
        Route::post('/{investment}/cancel', [\App\Http\Controllers\Account\InvestmentController::class, 'cancel'])->name('cancel');
        Route::get('/card/{card}/details', [\App\Http\Controllers\Account\InvestmentController::class, 'getCardDetails'])->name('card-details');
    });
    
    // Retraits
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Account\WithdrawalController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Account\WithdrawalController::class, 'store'])->name('store');
        Route::get('/{withdrawal}', [\App\Http\Controllers\Account\WithdrawalController::class, 'show'])->name('show');
        Route::post('/{withdrawal}/cancel', [\App\Http\Controllers\Account\WithdrawalController::class, 'cancel'])->name('cancel');
        Route::post('/calculate-fees', [\App\Http\Controllers\Account\WithdrawalController::class, 'calculateFees'])->name('calculate-fees');
        Route::get('/payment-method/{method}/info', [\App\Http\Controllers\Account\WithdrawalController::class, 'getPaymentMethodInfo'])->name('payment-method-info');
    });
    
    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Account\TransactionController::class, 'index'])->name('index');
        Route::get('/{transaction}', [Account\TransactionController::class, 'show'])->name('show');
        Route::get('/{transaction}/receipt', [\App\Http\Controllers\Account\TransactionController::class, 'downloadReceipt'])->name('receipt');
        Route::get('/export/csv', [\App\Http\Controllers\Account\TransactionController::class, 'export'])->name('export');
        Route::get('/stats/by-type', [\App\Http\Controllers\Account\TransactionController::class, 'getStatsByType'])->name('stats-by-type');
    });
    
    // Support
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Account\SupportController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Account\SupportController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Account\SupportController::class, 'store'])->name('store');
        Route::get('/{ticket}', [\App\Http\Controllers\Account\SupportController::class, 'show'])->name('show');
        Route::post('/{ticket}/reply', [\App\Http\Controllers\Account\SupportController::class, 'reply'])->name('reply');
        Route::post('/{ticket}/close', [\App\Http\Controllers\Account\SupportController::class, 'close'])->name('close');
        Route::post('/{ticket}/reopen', [\App\Http\Controllers\Account\SupportController::class, 'reopen'])->name('reopen');
        Route::get('/{ticket}/attachment/{media}', [\App\Http\Controllers\Account\SupportController::class, 'downloadAttachment'])->name('attachment');
    });
    
    // Profil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Account\ProfileController::class, 'index'])->name('home');
        Route::put('/', [\App\Http\Controllers\Account\ProfileController::class, 'update'])->name('update');
        Route::post('/avatar', [\App\Http\Controllers\Account\ProfileController::class, 'updateAvatar'])->name('update-avatar');
        Route::delete('/avatar', [\App\Http\Controllers\Account\ProfileController::class, 'deleteAvatar'])->name('delete-avatar');
        Route::put('/password', [\App\Http\Controllers\Account\ProfileController::class, 'updatePassword'])->name('update-password');
        
        // Notifications settings
        Route::get('/notifications', [\App\Http\Controllers\Account\ProfileController::class, 'notifications'])->name('notifications');
        Route::put('/notifications', [\App\Http\Controllers\Account\ProfileController::class, 'updateNotifications'])->name('update-notifications');
        
        // Parrainage
        Route::get('/referral', [\App\Http\Controllers\Account\ProfileController::class, 'referral'])->name('referral');
        
        // Activité
        Route::get('/activity', [\App\Http\Controllers\Account\ProfileController::class, 'activity'])->name('activity');
        
        // Suppression de compte
        Route::delete('/', [\App\Http\Controllers\Account\ProfileController::class, 'deleteAccount'])->name('delete');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Admin (Protected + Role Check)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super-admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/realtime-stats', [Admin\DashboardController::class, 'getRealtimeStats'])->name('realtime-stats');
    Route::get('/export-stats', [Admin\DashboardController::class, 'exportStats'])->name('export-stats');
    
    // Gestion des utilisateurs
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [Admin\UserController::class, 'index'])->name('index');
        Route::get('/{user}', [Admin\UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [Admin\UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/update-balance', [Admin\UserController::class, 'updateBalance'])->name('update-balance');
        Route::post('/{user}/toggle-status', [Admin\UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/export/csv', [Admin\UserController::class, 'export'])->name('export');
        
        // Impersonation
        Route::post('/{user}/impersonate', [Admin\UserController::class, 'impersonate'])->name('impersonate');
        Route::post('/stop-impersonating', [Admin\UserController::class, 'stopImpersonating'])->name('stop-impersonating');
    });
    
    // Gestion des investissements
    Route::prefix('investments')->name('investments.')->group(function () {
        Route::get('/', [Admin\InvestmentController::class, 'index'])->name('index');
        Route::get('/{investment}', [Admin\InvestmentController::class, 'show'])->name('show');
        Route::post('/{investment}/approve', [Admin\InvestmentController::class, 'approve'])->name('approve');
        Route::post('/{investment}/reject', [Admin\InvestmentController::class, 'reject'])->name('reject');
        Route::post('/{investment}/activate', [Admin\InvestmentController::class, 'activate'])->name('activate');
        Route::post('/{investment}/complete', [Admin\InvestmentController::class, 'complete'])->name('complete');
        Route::post('/{investment}/cancel', [Admin\InvestmentController::class, 'cancel'])->name('cancel');
        Route::post('/{investment}/refund', [Admin\InvestmentController::class, 'refund'])->name('refund');
        Route::put('/{investment}/notes', [Admin\InvestmentController::class, 'updateNotes'])->name('update-notes');
        Route::get('/export/csv', [Admin\InvestmentController::class, 'export'])->name('export');
    });
    
    // Gestion des retraits
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [Admin\WithdrawalController::class, 'index'])->name('index');
        Route::get('/{withdrawal}', [Admin\WithdrawalController::class, 'show'])->name('show');
        Route::post('/{withdrawal}/approve', [Admin\WithdrawalController::class, 'approve'])->name('approve');
        Route::post('/{withdrawal}/reject', [Admin\WithdrawalController::class, 'reject'])->name('reject');
        Route::post('/{withdrawal}/process', [Admin\WithdrawalController::class, 'process'])->name('process');
        Route::post('/{withdrawal}/complete', [Admin\WithdrawalController::class, 'complete'])->name('complete');
        Route::put('/{withdrawal}/notes', [Admin\WithdrawalController::class, 'updateNotes'])->name('update-notes');
        Route::get('/export/csv', [Admin\WithdrawalController::class, 'export'])->name('export');
    });
    
    // Gestion des transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [Admin\TransactionController::class, 'index'])->name('index');
        Route::get('/create', [Admin\TransactionController::class, 'create'])->name('create');
        Route::post('/', [Admin\TransactionController::class, 'store'])->name('store');
        Route::get('/{transaction}', [Admin\TransactionController::class, 'show'])->name('show');
        Route::put('/{transaction}/status', [Admin\TransactionController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{transaction}', [Admin\TransactionController::class, 'delete'])->name('delete');
        Route::get('/export/csv', [Admin\TransactionController::class, 'export'])->name('export');
    });
    
    // Gestion des cartes d'investissement
    Route::prefix('investment-cards')->name('investment-cards.')->group(function () {
        Route::get('/', [Admin\InvestmentCardController::class, 'index'])->name('index');
        Route::get('/create', [Admin\InvestmentCardController::class, 'create'])->name('create');
        Route::post('/', [Admin\InvestmentCardController::class, 'store'])->name('store');
        Route::get('/{card}/edit', [Admin\InvestmentCardController::class, 'edit'])->name('edit');
        Route::put('/{card}', [Admin\InvestmentCardController::class, 'update'])->name('update');
        Route::delete('/{card}', [Admin\InvestmentCardController::class, 'destroy'])->name('destroy');
        Route::post('/{card}/toggle-active', [Admin\InvestmentCardController::class, 'toggleActive'])->name('toggle-active');
        Route::post('/{card}/toggle-featured', [Admin\InvestmentCardController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/reorder', [Admin\InvestmentCardController::class, 'reorder'])->name('reorder');
        Route::post('/{card}/upload-image', [Admin\InvestmentCardController::class, 'uploadImage'])->name('upload-image');
    });
    
    // Gestion des moyens de paiement
    Route::prefix('payment-methods')->name('payment-methods.')->group(function () {
        Route::get('/', [Admin\PaymentMethodController::class, 'index'])->name('index');
        Route::get('/create', [Admin\PaymentMethodController::class, 'create'])->name('create');
        Route::post('/', [Admin\PaymentMethodController::class, 'store'])->name('store');
        Route::get('/{method}/edit', [Admin\PaymentMethodController::class, 'edit'])->name('edit');
        Route::put('/{method}', [Admin\PaymentMethodController::class, 'update'])->name('update');
        Route::delete('/{method}', [Admin\PaymentMethodController::class, 'destroy'])->name('destroy');
        Route::post('/{method}/toggle-active', [Admin\PaymentMethodController::class, 'toggleActive'])->name('toggle-active');
        Route::post('/reorder', [Admin\PaymentMethodController::class, 'reorder'])->name('reorder');
        Route::put('/{method}/config', [Admin\PaymentMethodController::class, 'updateConfig'])->name('update-config');
    });
    
    // Support (Admin view)
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [Admin\SupportController::class, 'index'])->name('index');
        Route::get('/{ticket}', [Admin\SupportController::class, 'show'])->name('show');
        Route::post('/{ticket}/reply', [Admin\SupportController::class, 'reply'])->name('reply');
        Route::post('/{ticket}/assign', [Admin\SupportController::class, 'assign'])->name('assign');
        Route::put('/{ticket}/status', [Admin\SupportController::class, 'updateStatus'])->name('update-status');
        Route::put('/{ticket}/priority', [Admin\SupportController::class, 'updatePriority'])->name('update-priority');
        Route::post('/{ticket}/close', [Admin\SupportController::class, 'close'])->name('close');
        Route::delete('/{ticket}', [Admin\SupportController::class, 'delete'])->name('delete');
        Route::get('/export/csv', [Admin\SupportController::class, 'export'])->name('export');
    });
    
    // Paramètres système
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [Admin\SettingController::class, 'index'])->name('index');
        Route::put('/', [Admin\SettingController::class, 'update'])->name('update');
        Route::post('/{key}/reset', [Admin\SettingController::class, 'reset'])->name('reset');
    });
    
    // Rapports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [Admin\ReportController::class, 'index'])->name('index');
        Route::get('/revenue', [Admin\ReportController::class, 'revenue'])->name('revenue');
        Route::get('/users', [Admin\ReportController::class, 'users'])->name('users');
        Route::get('/investments', [Admin\ReportController::class, 'investments'])->name('investments');
        Route::get('/withdrawals', [Admin\ReportController::class, 'withdrawals'])->name('withdrawals');
        Route::get('/{type}/export-pdf', [Admin\ReportController::class, 'exportPDF'])->name('export-pdf');
        Route::get('/{type}/export-excel', [Admin\ReportController::class, 'exportExcel'])->name('export-excel');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Authentification (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';