<?php

use App\Http\Controllers\{
    AdminDashBoardController,
    DonationController,
    FamilyAssistanceController,
    ForgotPasswordController,
    HazardMapController,
    HomeController,
    IncidentReportController,
    LandingPageController,
    LoginController,
    LogoutController,
    PatientCareReportController,
    ResponseRecordController,
    UserController
};
use App\Http\Middleware\CheckPasswordUpdate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::controller(LandingPageController::class)->group(function() {
    Route::get('/', 'index')->name('landingPage');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('loginPage');
    Route::post('/user-login', 'login')->name('login');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'index')->name('password.request');
    Route::post('forgot-password', 'forgotPassword')->name('password.email');
    Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('reset-password', 'resetPassword')->name('password.save');
});

// Incident Reports
Route::controller(IncidentReportController::class)->group(function () {
    Route::get('/incident-report', 'create')->name('incident_report.create');
    Route::post('/incident-report', 'store')->name('incident_report.store');
    Route::get('/incident-find-report', 'findReport')->name('incident_report.find');
});

// Family Assistance
Route::controller(FamilyAssistanceController::class)->group(function () {
    Route::get('/family-assistance', 'create')->name('request.family.assistance');
    Route::post('/family-assistance', 'store')->name('store.family.assistance');
});

// Donations
Route::controller(DonationController::class)->group(function () {
    Route::get('/donor-form', 'create')->name('create.donation');
    Route::post('/donor-form', 'store')->name('store.donation');
});


/*
|--------------------------------------------------------------------------
| Authentication Required Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::controller(LogoutController::class)->group(function() {
        Route::post('/logout', 'logout')->name('logout');
    });

    // Password Update Routes
    Route::controller(UserController::class)->group(function () {
        Route::get('update-password', 'update_user_password')->name('update.password');
        Route::post('update-password', 'save_password')->name('save.password');
    });

    // Routes that require password update check
    Route::middleware([CheckPasswordUpdate::class])->group(function () {
        // Home
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // User Management
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'show')->name('users');
            Route::get('/add-user', 'show_addUser')->name('users.create');
            Route::get('/users-details/{id}', 'details')->name('users.details');
            Route::post('/add-user', 'store')->name('users.add');
            Route::post('/edit-user/{id}', 'edit')->name('users.edit');
            Route::post('/disable-user/{id}', 'disable')->name('users.disable');
        });

        // Response Records
        Route::controller(ResponseRecordController::class)->group(function () {
            Route::get('/response-records', 'index')->name('response_records.index');
            Route::get('/response-records/create', 'create')->name('response_records.create');
            Route::post('/response-records/store', 'store')->name('response_records.store');
            Route::get('/response-records/{id}/edit', 'edit')->name('response_records.edit');
            Route::post('/response-records/{id}', 'update')->name('response_records.update');
            Route::get('/response-records/{id}/download', 'download')->name('response_records.download');
            Route::get('/response-records/monthly-report', 'generateMonthlyReport')->name('response_records.monthly_report');
            Route::get('/incident/{case}/{id}/response/create', 'incident_response_create')->name('response_records.incident.create');
            Route::get('/patient-care/{id}/response/create', 'patient_care_response_create')->name('response_records.patient_care.create');
        });

        // Incident Reports
        Route::controller(IncidentReportController::class)->group(function () {
            Route::get('/incident-reports', 'showAllReports')->name('incident_report.show_all');
            Route::get('/incident-report/{case}/{id}', 'showReport')->name('incident_report.show');
            Route::get('/incident-report/{id}', 'confirmReport')->name('incident_report.confirm');
            Route::post('/incident-reports/{case}/{id}', 'delete')->name('incident_report.delete');
            Route::get('/incident-reports/monthly-report', 'generateMonthlyReport')->name('incident_report.monthly_report');
        });

        // Patient Care
        Route::controller(PatientCareReportController::class)->group(function () {
            Route::get('/patient-care', 'index')->name('patient_care.index');
            Route::post('/patient-care', 'store')->name('patient_care.store');
            Route::get('/patient-care/{id}', 'show')->name('patient_care.show');
            Route::get('/patient-care/{id}/pdf', 'download')->name('patient_care.download');
        });

        // Hazard Map
        Route::controller(HazardMapController::class)->group(function() {
            Route::get('/hazard-map', 'index')->name('hazard_map.index');
            Route::get('/hazard-map/create', 'create')->name('hazard_map.create');
            Route::post('/hazard-map/create', 'store')->name('hazard_map.store');
            Route::get('/hazard-map/{id}', 'edit')->name('hazard_map.edit');
            Route::post('/hazard-map/{id}/update', 'update')->name('hazard_map.update');
            Route::post('/disable-hazard/{id}', 'updateHazardStatus')->name('hazard_map.disable');
            Route::get('/shelter/create', 'shelterCreate')->name('shelter.create');
            Route::post('/shelter/create', 'shelterStore')->name('shelter.store');
            Route::get('/shelter/{id}', 'shelter_edit')->name('shelter.edit');
            Route::post('/shelter/{id}/update', 'shelter_update')->name('shelter.update');
            Route::post('/shelter/{id}/delete', 'shelterDelete')->name('shelter.delete');
            Route::get('/hazards-shelters', 'view')->name('hazard_map.shelter');
        });

        // Family Assistance
        Route::controller(FamilyAssistanceController::class)->group(function () {
            Route::get('/family-assistance-records', 'index')->name('family.assistance.records');
            Route::get('/family-assistance-record/{id}', 'view')->name('family.assistance.record');
            Route::post('/family-assistance-print-record', 'print_record')->name('family.assistance.print');
            Route::get('/family-assistance/update/{id}', 'view_update')->name('family.assistance.view.update');
            Route::post('/family-assistance/update/{id}', 'update')->name('family.assistance.update');
        });

        // Donations
        Route::controller(DonationController::class)->group(function () {
            Route::get('/donations', 'index')->name('donations');
            Route::get('donation/{type}/{id}', 'view')->name('view.donation');
            Route::post('pickup/donation', 'pickup_donation')->name('pickup.donation');
            Route::get('print/donation/{type}/{id}', 'print_donation_report')->name('print.donation');
        });

        // Admin Dashboard
        Route::get('/admin-dashboard', [AdminDashBoardController::class, 'index']);
    });
});

/*
|--------------------------------------------------------------------------
| Catch-all Route
|--------------------------------------------------------------------------
*/
Route::any('{any}', function () {
    return redirect()->route('landingPage');
})->where('any', '.*')->name('not-found');