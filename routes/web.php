<?php

use App\Http\Controllers\PaystackController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Members dashboard routes
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role:member'])
    ->name('dashboard');

// Super-admin & admins dashboard routes
Volt::route('admin/dashboard', 'admins.dashboard')
    ->middleware(['auth', 'verified', 'role:super-admin|admin'])
    ->name('admin.dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Admin routes
    Volt::route('admin/roles-management', 'admins.roles')
    ->middleware(['permission:view.roles|update.roles|create.roles|delete.roles'])
    ->name('roles');

    Volt::route('admin/members-management', 'admins.members')
    ->middleware(['permission:view.member|update.member|create.member|delete.member'])
    ->name('members');

    Volt::route('admin/agent-management-sys', 'admins.agents')
    ->middleware(['permission:view.agent|update.agent|create.agent|delete.agent'])
    ->name('agents');

    Volt::route('admin/payments-management-sys', 'admins.payments')
    ->middleware(['permission:view.payment|update.payment|create.payment|delete.payment'])
    ->name('payments');

    Volt::route('admin/notification-sys', 'admins.notifications')
    ->middleware(['permission:view.notification|update.notification|create.notification|delete.notification'])
    ->name('notifications');
    Volt::route('admin/withdrawals-management', 'admins.withdrawals')
    ->middleware(['permission:view.withdrawal|update.withdrawal|create.withdrawal|delete.withdrawal'])
    ->name('admin.withdrawals');
    
    // Member routes
    Volt::route('users/wallets-sys', 'users.wallets')
    ->middleware(['permission:view.wallet|fund.wallet|withdraw.wallet'])
    ->name('wallets');
    Volt::route('users/deposits-sys', 'users.deposits')
    ->middleware(['permission:fund.wallet'])
    ->name('deposits');
    Volt::route('users/deposits-sys-log', 'users.deposits-log')
    ->middleware(['permission:fund.wallet|view.wallet'])
    ->name('deposits.log');
    Volt::route('users/boards-sys', 'users.boards')
    ->middleware(['permission:view.board'])
    ->name('boards');
    Volt::route('users/boards/{level}/trees-sys', 'users.trees')
    ->middleware(['permission:view.tree'])
    ->name('trees');
    Volt::route('users/earnings-logs', 'users.earnings-log')
    ->middleware(['role:member'])
    ->name('earnings.log');
    Volt::route('users/withdrawals-sys', 'users.withdraws')
    ->middleware(['permission:withdraw.wallet'])
    ->name('withdrawal');
    Volt::route('users/withdrawals-log-sys', 'users.withdrawal-log')
    ->middleware(['permission:withdraw.wallet|view.wallet'])
    ->name('withdrawal.log');
    // Volt::route('admin/deposits-management', 'admins.deposits')->name('deposits');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
    // Paystack Routes
    Route::get('/paystack/callback', [PaystackController::class, 'handleCallback'])->name('paystack.callback');
});

require __DIR__.'/auth.php';
