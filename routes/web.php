<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\WelcomeController;
use App\Http\Controllers\Dashboard\TrackerController;
use App\Http\Controllers\Dashboard\ProgressController;
use App\Http\Controllers\Dashboard\CommunityController;
use App\Http\Controllers\Dashboard\TransformationProfileController;
use App\Http\Controllers\Dashboard\ReferralController;
use App\Http\Controllers\Dashboard\SkinAssessmentController;
use App\Http\Controllers\GuaranteeFaqController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProgramController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Http\Controllers\Admin\AdminMilestoneController;
use App\Http\Controllers\Admin\AdminGlowScanController;
use App\Http\Controllers\Admin\SkinAssessmentsController as AdminSkinAssessmentsController;
use App\Http\Controllers\Admin\AdminExportController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminRecommendationController;
use App\Http\Controllers\Admin\AdminReferralController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Logo Preview (Development/Design Only - Remove in Production)
Route::get('/logo-preview', function () {
    return view('logo-preview');
});

// Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Main dashboard route (with both 'dashboard' and 'dashboard.welcome' names for compatibility)
    Route::get('/dashboard', [WelcomeController::class, 'index'])->name('dashboard');

    // Other dashboard routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/tracker', [TrackerController::class, 'index'])->name('tracker');
        Route::post('/tracker/baseline', [TrackerController::class, 'storeBaseline'])->name('tracker.baseline');
        Route::post('/tracker/log', [TrackerController::class, 'storeLog'])->name('tracker.log');
        Route::post('/tracker/current-photo', [TrackerController::class, 'updateCurrentPhoto'])->name('tracker.current-photo');
        Route::get('/progress', [ProgressController::class, 'index'])->name('progress');
        Route::get('/community', [CommunityController::class, 'index'])->name('community');
        Route::get('/my-profile', [TransformationProfileController::class, 'index'])->name('my-profile');
        Route::get('/referral', [ReferralController::class, 'index'])->name('referral');
        Route::post('/referral/send', [ReferralController::class, 'sendInvite'])->name('referral.send');
        Route::get('/guarantee-faq', [GuaranteeFaqController::class, 'index'])->name('guarantee-faq');

        // Skin Glow Assessment
        Route::get('/skin-assessment', [SkinAssessmentController::class, 'index'])->name('skin-assessment.index');
        Route::get('/skin-assessment/create/{milestoneDay}', [SkinAssessmentController::class, 'create'])->name('skin-assessment.create');
        Route::post('/skin-assessment', [SkinAssessmentController::class, 'store'])->name('skin-assessment.store');
        Route::get('/skin-assessment/{assessment}', [SkinAssessmentController::class, 'show'])->name('skin-assessment.show');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (protected by auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::patch('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::get('/users/{user}/export', [AdminUserController::class, 'export'])->name('users.export');

    // Program Management
    Route::get('/programs', [AdminProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/{enrollment}', [AdminProgramController::class, 'show'])->name('programs.show');

    // Analytics
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export', [AdminAnalyticsController::class, 'export'])->name('analytics.export');

    // Daily Logs
    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{log}', [AdminLogController::class, 'show'])->name('logs.show');
    Route::get('/logs/export', [AdminLogController::class, 'export'])->name('logs.export');

    // Milestones
    Route::get('/milestones', [AdminMilestoneController::class, 'index'])->name('milestones.index');
    Route::patch('/milestones/{milestone}/claim', [AdminMilestoneController::class, 'markClaimed'])->name('milestones.claim');

    // Glow Scans
    Route::get('/glow-scans', [AdminGlowScanController::class, 'index'])->name('glow-scans.index');
    Route::get('/glow-scans/{scan}', [AdminGlowScanController::class, 'show'])->name('glow-scans.show');

    // Skin Assessments
    Route::get('/skin-assessments', [AdminSkinAssessmentsController::class, 'index'])->name('skin-assessments.index');
    Route::get('/skin-assessments/{assessment}', [AdminSkinAssessmentsController::class, 'show'])->name('skin-assessments.show');

    // Exports
    Route::get('/exports', [AdminExportController::class, 'index'])->name('exports.index');
    Route::post('/exports/users', [AdminExportController::class, 'users'])->name('exports.users');
    Route::post('/exports/logs', [AdminExportController::class, 'logs'])->name('exports.logs');
    Route::post('/exports/baselines', [AdminExportController::class, 'baselines'])->name('exports.baselines');
    Route::post('/exports/improvements', [AdminExportController::class, 'improvements'])->name('exports.improvements');
    Route::post('/exports/skin-assessments', [AdminExportController::class, 'skinAssessments'])->name('exports.skin-assessments');
    Route::post('/exports/milestones', [AdminExportController::class, 'milestones'])->name('exports.milestones');
    Route::post('/exports/programs', [AdminExportController::class, 'programs'])->name('exports.programs');
    Route::post('/exports/date-range', [AdminExportController::class, 'dateRange'])->name('exports.date-range');
    Route::post('/exports/complete', [AdminExportController::class, 'complete'])->name('exports.complete');

    // Settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

    // Recommendations
    Route::get('/recommendations', [AdminRecommendationController::class, 'index'])->name('recommendations.index');
    Route::get('/recommendations/create', [AdminRecommendationController::class, 'create'])->name('recommendations.create');
    Route::post('/recommendations', [AdminRecommendationController::class, 'store'])->name('recommendations.store');
    Route::get('/recommendations/{recommendation}/edit', [AdminRecommendationController::class, 'edit'])->name('recommendations.edit');
    Route::put('/recommendations/{recommendation}', [AdminRecommendationController::class, 'update'])->name('recommendations.update');
    Route::delete('/recommendations/{recommendation}', [AdminRecommendationController::class, 'destroy'])->name('recommendations.destroy');
    Route::patch('/recommendations/{recommendation}/toggle-active', [AdminRecommendationController::class, 'toggleActive'])->name('recommendations.toggle-active');

    // Referrals
    Route::get('/referrals', [AdminReferralController::class, 'index'])->name('referrals.index');

    // Monthly Rewards (before {referral} route to avoid conflicts)
    Route::get('/referrals/monthly-rewards', [AdminReferralController::class, 'monthlyRewards'])->name('referrals.monthly-rewards');
    Route::patch('/referrals/rewards/{reward}/mark-paid', [AdminReferralController::class, 'markRewardPaid'])->name('referrals.rewards.mark-paid');
    Route::post('/referrals/generate-monthly-rewards', [AdminReferralController::class, 'generateMonthlyRewards'])->name('referrals.generate-monthly-rewards');

    // Free Months
    Route::get('/referrals/free-months', [AdminReferralController::class, 'freeMonths'])->name('referrals.free-months');
    Route::patch('/referrals/free-months/{freeMonth}/approve', [AdminReferralController::class, 'approveFreeMonth'])->name('referrals.free-months.approve');

    // Individual Referral
    Route::get('/referrals/{referral}', [AdminReferralController::class, 'show'])->name('referrals.show');
    Route::patch('/referrals/{referral}/subscription', [AdminReferralController::class, 'updateSubscriptionStatus'])->name('referrals.update-subscription');
});

require __DIR__.'/auth.php';
