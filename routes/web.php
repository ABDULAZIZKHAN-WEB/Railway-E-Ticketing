<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainSearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Train search routes
Route::get('/search-trains', [TrainSearchController::class, 'showSearchForm'])->name('search.trains');
Route::post('/search-trains', [TrainSearchController::class, 'search'])->name('search.trains.post');

// Public pages
Route::get('/live-tracking', function () {
    return view('pages.live-tracking');
})->name('live.tracking');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/help', function () {
    return view('pages.help');
})->name('help');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

// Debug routes
Route::get('/debug-auth', function () {
    return [
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
        'session' => session()->all()
    ];
});

Route::get('/test', function () {
    return 'Laravel is working! Time: ' . now();
});

Route::get('/test-db', function () {
    try {
        $userCount = \App\Models\User::count();
        $roleCount = DB::table('roles')->count();
        return [
            'database' => 'connected',
            'users' => $userCount,
            'roles' => $roleCount,
            'time' => now()
        ];
    } catch (\Exception $e) {
        return [
            'database' => 'error',
            'message' => $e->getMessage()
        ];
    }
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-bookings', function () {
        return view('bookings.my-bookings');
    })->name('my.bookings');
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile');

    // Booking routes
    Route::get('/booking/seat-selection', function () {
        return view('bookings.seat-selection');
    })->name('booking.seat-selection');
    Route::get('/booking/payment', function () {
        return view('bookings.payment');
    })->name('booking.payment');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/trains', [App\Http\Controllers\Admin\TrainController::class, 'index'])->name('admin.trains');
    Route::get('/trains/create', [App\Http\Controllers\Admin\TrainController::class, 'create'])->name('admin.trains.create');
    Route::post('/trains', [App\Http\Controllers\Admin\TrainController::class, 'store'])->name('admin.trains.store');
    Route::get('/trains/{train}/edit', [App\Http\Controllers\Admin\TrainController::class, 'edit'])->name('admin.trains.edit');
    Route::put('/trains/{train}', [App\Http\Controllers\Admin\TrainController::class, 'update'])->name('admin.trains.update');
    Route::delete('/trains/{train}', [App\Http\Controllers\Admin\TrainController::class, 'destroy'])->name('admin.trains.destroy');
    
    Route::get('/stations', [App\Http\Controllers\Admin\StationController::class, 'index'])->name('admin.stations');
    Route::get('/stations/create', [App\Http\Controllers\Admin\StationController::class, 'create'])->name('admin.stations.create');
    Route::post('/stations', [App\Http\Controllers\Admin\StationController::class, 'store'])->name('admin.stations.store');
    Route::get('/stations/{station}/edit', [App\Http\Controllers\Admin\StationController::class, 'edit'])->name('admin.stations.edit');
    Route::put('/stations/{station}', [App\Http\Controllers\Admin\StationController::class, 'update'])->name('admin.stations.update');
    Route::delete('/stations/{station}', [App\Http\Controllers\Admin\StationController::class, 'destroy'])->name('admin.stations.destroy');
    
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
});

// Station Master routes
Route::middleware(['auth', 'role:station_master'])->prefix('station-master')->group(function () {
    Route::get('/schedule', [App\Http\Controllers\StationMaster\ScheduleController::class, 'index'])->name('station-master.schedule');
    Route::put('/schedule/{schedule}', [App\Http\Controllers\StationMaster\ScheduleController::class, 'update'])->name('station-master.schedule.update');
    Route::patch('/schedule/{schedule}/delay', [App\Http\Controllers\StationMaster\ScheduleController::class, 'reportDelay'])->name('station-master.schedule.delay');
    Route::get('/delays', [App\Http\Controllers\StationMaster\ScheduleController::class, 'delays'])->name('station-master.delays');
    Route::post('/delays', [App\Http\Controllers\StationMaster\ScheduleController::class, 'storeDelay'])->name('station-master.delays.store');
    Route::put('/delays/{schedule}', [App\Http\Controllers\StationMaster\ScheduleController::class, 'updateDelay'])->name('station-master.delays.update');
    Route::patch('/delays/{schedule}/resolve', [App\Http\Controllers\StationMaster\ScheduleController::class, 'resolveDelay'])->name('station-master.delays.resolve');
    Route::get('/platforms', [App\Http\Controllers\StationMaster\PlatformController::class, 'index'])->name('station-master.platforms');
    Route::get('/platforms/create', [App\Http\Controllers\StationMaster\PlatformController::class, 'create'])->name('station-master.platforms.create');
    Route::post('/platforms', [App\Http\Controllers\StationMaster\PlatformController::class, 'store'])->name('station-master.platforms.store');
    Route::get('/platforms/{platform}', [App\Http\Controllers\StationMaster\PlatformController::class, 'show'])->name('station-master.platforms.show');
    Route::get('/platforms/{platform}/edit', [App\Http\Controllers\StationMaster\PlatformController::class, 'edit'])->name('station-master.platforms.edit');
    Route::put('/platforms/{platform}', [App\Http\Controllers\StationMaster\PlatformController::class, 'update'])->name('station-master.platforms.update');
    Route::delete('/platforms/{platform}', [App\Http\Controllers\StationMaster\PlatformController::class, 'destroy'])->name('station-master.platforms.destroy');
    Route::patch('/platforms/{platform}/status', [App\Http\Controllers\StationMaster\PlatformController::class, 'updateStatus'])->name('station-master.platforms.update-status');
    Route::post('/platforms/control', [App\Http\Controllers\StationMaster\PlatformController::class, 'controlPanelUpdate'])->name('station-master.platforms.control-update');
    Route::get('/announcements', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'index'])->name('station-master.announcements');
    Route::get('/announcements/create', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'create'])->name('station-master.announcements.create');
    Route::post('/announcements', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'store'])->name('station-master.announcements.store');
    Route::get('/announcements/{announcement}', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'show'])->name('station-master.announcements.show');
    Route::get('/announcements/{announcement}/edit', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'edit'])->name('station-master.announcements.edit');
    Route::put('/announcements/{announcement}', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'update'])->name('station-master.announcements.update');
    Route::delete('/announcements/{announcement}', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'destroy'])->name('station-master.announcements.destroy');
    Route::patch('/announcements/{announcement}/publish', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'publish'])->name('station-master.announcements.publish');
    Route::patch('/announcements/{announcement}/complete', [App\Http\Controllers\StationMaster\AnnouncementController::class, 'complete'])->name('station-master.announcements.complete');
});

// Ticket Seller routes
Route::middleware(['auth', 'role:ticket_seller'])->prefix('ticket-seller')->group(function () {
    Route::get('/booking', [App\Http\Controllers\TicketSeller\BookingController::class, 'index'])->name('ticket-seller.booking');
    Route::post('/booking/search', [App\Http\Controllers\TicketSeller\BookingController::class, 'searchTrains'])->name('ticket-seller.booking.search');
    Route::get('/search', function () {
        return view('ticket-seller.search');
    })->name('ticket-seller.search');
    Route::get('/print', function () {
        return view('ticket-seller.print');
    })->name('ticket-seller.print');

    Route::get('/cash-report', function () {
        return view('ticket-seller.cash-report');
    })->name('ticket-seller.cash-report');
});
