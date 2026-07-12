<?php

use App\Http\Controllers\CronController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DepositController;
use App\Http\Controllers\Dashboard\WithdrawController;
use App\Http\Controllers\Dashboard\InvestController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ReferralController;
use App\Http\Controllers\Dashboard\TransferController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ImpersonationController;
use App\Http\Controllers\Admin\DepositMethodController;
use App\Http\Controllers\Admin\DepositLogController;
use App\Http\Controllers\Admin\WithdrawalMethodController;
use App\Http\Controllers\Admin\WithdrawalRequestController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\ReferralController as AdminReferralController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── Guest pages ──────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/terms', fn () => view('terms'))->name('terms');

// ── Cron (secured via CRON_SECRET token) ─────────────────────
Route::get('/cron/process-investments', [CronController::class, 'processInvestments'])
    ->name('cron.process-investments');

// ── Deploy hook (secured via DEPLOY_SECRET token) ─────────────
Route::get('/deploy/run', [DeployController::class, 'run'])
    ->name('deploy.run');

// ── Auth (guests only) ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'create'])->name('login');
    Route::post('/login',   [LoginController::class,    'store'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register',[RegisterController::class, 'store'])->name('register.post');
});

// ── Logout ───────────────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// ── Email verification ───────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard.index');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ── Dashboard (auth + verified) ──────────────────────────────
Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

    Route::get('/',             [DashboardController::class, 'index'])->name('index');

    // Deposit
    Route::get('/deposit',                          [DepositController::class, 'index'])->name('deposit');
    Route::post('/deposit/{method}',                [DepositController::class, 'payment'])->name('deposit.payment');
    Route::post('/deposit/{method}/confirm',        [DepositController::class, 'confirm'])->name('deposit.confirm');

    // Stub routes — views return "coming soon" until built
    Route::get('/withdraw',                    [WithdrawController::class, 'index'])->name('withdraw');
    Route::get('/withdraw/{method}',           [WithdrawController::class, 'request'])->name('withdraw.request');
    Route::post('/withdraw/{method}',          [WithdrawController::class, 'submit'])->name('withdraw.submit');
    Route::get('/invest',              [InvestController::class, 'index'])->name('invest');
    Route::post('/invest/{plan}/join', [InvestController::class, 'join'])->name('invest.join');
    Route::get('/plans',               [InvestController::class, 'plans'])->name('plans');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/profile',                    [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/personal',          [ProfileController::class, 'updatePersonal'])->name('profile.personal');
    Route::post('/profile/wallets',           [ProfileController::class, 'updateWallets'])->name('profile.wallets');
    Route::post('/profile/password',          [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/settings',          [ProfileController::class, 'updateSettings'])->name('profile.settings');
    Route::get('/swap',         fn () => view('dashboard.swap'))->name('swap');
    Route::get('/transfer',     [TransferController::class, 'index'])->name('transfer');
    Route::post('/transfer',    [TransferController::class, 'submit'])->name('transfer.submit');
    Route::get('/referrals',    [ReferralController::class, 'index'])->name('referrals');
});

// ── Stop impersonation (available to the impersonated session) ────
Route::middleware('auth')
    ->post('/admin/stop-impersonating', [ImpersonationController::class, 'stop'])
    ->name('admin.impersonate.stop');

// ── Admin ─────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin login
    Route::get('/login',  [AdminLoginController::class, 'create'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'store'])->name('login.post');

    // Authenticated admins only
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/users',                     [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',              [AdminUserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/fund',        [AdminUserController::class, 'fund'])->name('users.fund');
        Route::post('/users/{user}/deduct',      [AdminUserController::class, 'deduct'])->name('users.deduct');
        Route::post('/users/{user}/impersonate', [ImpersonationController::class, 'start'])->name('users.impersonate');

        // Deposit methods
        Route::post('/deposit-methods/{depositMethod}/toggle', [DepositMethodController::class, 'toggle'])->name('deposit-methods.toggle');
        Route::resource('deposit-methods', DepositMethodController::class)->except(['show']);

        // Deposit logs
        Route::get('/deposits',                   [DepositLogController::class, 'index'])->name('deposits.index');
        Route::post('/deposits/{deposit}/approve', [DepositLogController::class, 'approve'])->name('deposits.approve');
        Route::post('/deposits/{deposit}/reject',  [DepositLogController::class, 'reject'])->name('deposits.reject');

        // Withdrawal methods
        Route::post('/withdrawal-methods/{withdrawalMethod}/toggle', [WithdrawalMethodController::class, 'toggle'])->name('withdrawal-methods.toggle');
        Route::resource('withdrawal-methods', WithdrawalMethodController::class)->except(['show']);

        // Withdrawal logs
        Route::get('/withdrawals',                    [WithdrawalRequestController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalRequestController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject',  [WithdrawalRequestController::class, 'reject'])->name('withdrawals.reject');

        // Transaction history (global ledger)
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

        // Investment logs
        Route::get('/investments', [AdminInvestmentController::class, 'index'])->name('investments.index');

        // Referrals
        Route::get('/referrals',         [AdminReferralController::class, 'index'])->name('referrals.index');
        Route::get('/referrals/{user}',  [AdminReferralController::class, 'show'])->name('referrals.show');

        // Settings
        Route::get('/settings',  [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings',  [SettingController::class, 'update'])->name('settings.update');

        // FAQs
        Route::resource('faqs', FaqController::class)->except(['show']);

        // Broadcast email
        Route::get('/mail',      [MailController::class, 'create'])->name('mail.create');
        Route::post('/mail',     [MailController::class, 'send'])->name('mail.send');

        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
    });
});
