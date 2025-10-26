<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TrainSearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Public routes
Route::get('/', [PageController::class, 'welcome']);

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

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // My Bookings
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my.bookings');
    
    // Booking flow
    Route::post('/booking/select-train', [BookingController::class, 'selectTrain'])->name('booking.select-train');
    Route::get('/booking/seat-selection', [BookingController::class, 'seatSelection'])->name('booking.seat-selection');
    Route::get('/booking/payment', [BookingController::class, 'payment'])->name('booking.payment');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Train Management
    Route::get('/trains', [\App\Http\Controllers\Admin\TrainController::class, 'index'])->name('admin.trains');
    Route::get('/trains/create', [\App\Http\Controllers\Admin\TrainController::class, 'create'])->name('admin.trains.create');
    Route::post('/trains', [\App\Http\Controllers\Admin\TrainController::class, 'store'])->name('admin.trains.store');
    Route::get('/trains/{train}/edit', [\App\Http\Controllers\Admin\TrainController::class, 'edit'])->name('admin.trains.edit');
    Route::put('/trains/{train}', [\App\Http\Controllers\Admin\TrainController::class, 'update'])->name('admin.trains.update');
    Route::delete('/trains/{train}', [\App\Http\Controllers\Admin\TrainController::class, 'destroy'])->name('admin.trains.destroy');
    
    // Station Management
    Route::get('/stations', [\App\Http\Controllers\Admin\StationController::class, 'index'])->name('admin.stations');
    Route::get('/stations/create', [\App\Http\Controllers\Admin\StationController::class, 'create'])->name('admin.stations.create');
    Route::get('/stations/{station}/edit', [\App\Http\Controllers\Admin\StationController::class, 'edit'])->name('admin.stations.edit');
    Route::post('/stations', [\App\Http\Controllers\Admin\StationController::class, 'store'])->name('admin.stations.store');
    Route::put('/stations/{station}', [\App\Http\Controllers\Admin\StationController::class, 'update'])->name('admin.stations.update');
    Route::delete('/stations/{station}', [\App\Http\Controllers\Admin\StationController::class, 'destroy'])->name('admin.stations.destroy');
    Route::post('/stations/{station}/toggle-status', [\App\Http\Controllers\Admin\StationController::class, 'toggleStatus'])->name('admin.stations.toggle-status');
    
    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('admin.users.reset-password');
    
    // Train Schedule Management
    Route::get('/train-schedules', [\App\Http\Controllers\Admin\TrainScheduleController::class, 'index'])->name('admin.train-schedules.index');
    Route::get('/train-schedules/create', [\App\Http\Controllers\Admin\TrainScheduleController::class, 'create'])->name('admin.train-schedules.create');
    Route::post('/train-schedules', [\App\Http\Controllers\Admin\TrainScheduleController::class, 'store'])->name('admin.train-schedules.store');
    Route::get('/train-schedules/{schedule}/edit', [\App\Http\Controllers\Admin\TrainScheduleController::class, 'edit'])->name('admin.train-schedules.edit');
    Route::put('/train-schedules/{schedule}', [\App\Http\Controllers\Admin\TrainScheduleController::class, 'update'])->name('admin.train-schedules.update');
    Route::delete('/train-schedules/{schedule}', [\App\Http\Controllers\Admin\TrainScheduleController::class, 'destroy'])->name('admin.train-schedules.destroy');
    
    // Route Management
    Route::get('/routes', [\App\Http\Controllers\Admin\RouteController::class, 'index'])->name('admin.routes.index');
    Route::get('/routes/create', [\App\Http\Controllers\Admin\RouteController::class, 'create'])->name('admin.routes.create');
    Route::post('/routes', [\App\Http\Controllers\Admin\RouteController::class, 'store'])->name('admin.routes.store');
    Route::get('/routes/{route}/edit', [\App\Http\Controllers\Admin\RouteController::class, 'edit'])->name('admin.routes.edit');
    Route::put('/routes/{route}', [\App\Http\Controllers\Admin\RouteController::class, 'update'])->name('admin.routes.update');
    Route::delete('/routes/{route}', [\App\Http\Controllers\Admin\RouteController::class, 'destroy'])->name('admin.routes.destroy');
    
    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/sales', [\App\Http\Controllers\Admin\ReportController::class, 'salesReport'])->name('admin.reports.sales');
    Route::get('/reports/trains', [\App\Http\Controllers\Admin\ReportController::class, 'trainReport'])->name('admin.reports.trains');
    Route::get('/reports/stations', [\App\Http\Controllers\Admin\ReportController::class, 'stationReport'])->name('admin.reports.stations');
});

// Station Master routes
Route::middleware(['auth', 'role:station_master'])->prefix('station-master')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\StationMaster\DashboardController::class, 'index'])->name('station-master.dashboard');
    Route::get('/schedule', [\App\Http\Controllers\StationMaster\ScheduleController::class, 'index'])->name('station-master.schedule');
    Route::put('/schedule/{schedule}', [\App\Http\Controllers\StationMaster\ScheduleController::class, 'update'])->name('station-master.schedule.update');
    Route::patch('/schedule/{schedule}/delay', [\App\Http\Controllers\StationMaster\ScheduleController::class, 'reportDelay'])->name('station-master.schedule.report-delay');
    Route::get('/announcements', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'index'])->name('station-master.announcements');
    Route::post('/announcements', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'store'])->name('station-master.announcements.store');
    Route::get('/announcements/create', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'create'])->name('station-master.announcements.create');
    Route::get('/announcements/{announcement}/edit', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'edit'])->name('station-master.announcements.edit');
    Route::put('/announcements/{announcement}', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'update'])->name('station-master.announcements.update');
    Route::delete('/announcements/{announcement}', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'destroy'])->name('station-master.announcements.destroy');
    Route::patch('/announcements/{announcement}/publish', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'publish'])->name('station-master.announcements.publish');
    Route::patch('/announcements/{announcement}/complete', [\App\Http\Controllers\StationMaster\AnnouncementController::class, 'complete'])->name('station-master.announcements.complete');
    
    // Delays Management
    Route::get('/delays', [\App\Http\Controllers\StationMaster\DelaysController::class, 'index'])->name('station-master.delays');
    Route::post('/delays', [\App\Http\Controllers\StationMaster\DelaysController::class, 'store'])->name('station-master.delays.store');
    Route::put('/delays/{schedule}', [\App\Http\Controllers\StationMaster\DelaysController::class, 'update'])->name('station-master.delays.update');
    Route::patch('/delays/{schedule}/resolve', [\App\Http\Controllers\StationMaster\DelaysController::class, 'resolve'])->name('station-master.delays.resolve');
    
    // Platform Management
    Route::get('/platforms', [\App\Http\Controllers\StationMaster\PlatformController::class, 'index'])->name('station-master.platforms');
    Route::get('/platforms/create', [\App\Http\Controllers\StationMaster\PlatformController::class, 'create'])->name('station-master.platforms.create');
    Route::post('/platforms', [\App\Http\Controllers\StationMaster\PlatformController::class, 'store'])->name('station-master.platforms.store');
    Route::get('/platforms/{platform}', [\App\Http\Controllers\StationMaster\PlatformController::class, 'show'])->name('station-master.platforms.show');
    Route::get('/platforms/{platform}/edit', [\App\Http\Controllers\StationMaster\PlatformController::class, 'edit'])->name('station-master.platforms.edit');
    Route::put('/platforms/{platform}', [\App\Http\Controllers\StationMaster\PlatformController::class, 'update'])->name('station-master.platforms.update');
    Route::delete('/platforms/{platform}', [\App\Http\Controllers\StationMaster\PlatformController::class, 'destroy'])->name('station-master.platforms.destroy');
    Route::patch('/platforms/{platform}/update-status', [\App\Http\Controllers\StationMaster\PlatformController::class, 'updateStatus'])->name('station-master.platforms.update-status');
    Route::post('/platforms/control-panel', [\App\Http\Controllers\StationMaster\PlatformController::class, 'controlPanelUpdate'])->name('station-master.platforms.control-panel');
});

// Ticket Seller routes
Route::middleware(['auth', 'role:ticket_seller'])->prefix('ticket-seller')->group(function () {
    Route::get('/booking', [\App\Http\Controllers\TicketSeller\BookingController::class, 'index'])->name('ticket-seller.booking');
    Route::post('/booking/search', [\App\Http\Controllers\TicketSeller\BookingController::class, 'searchTrains'])->name('ticket-seller.booking.search');
    Route::get('/booking/seats', [\App\Http\Controllers\TicketSeller\BookingController::class, 'index'])->name('ticket-seller.booking.seats.get');
    Route::post('/booking/seats', [\App\Http\Controllers\TicketSeller\BookingController::class, 'showAvailableSeats'])->name('ticket-seller.booking.seats');
    Route::post('/booking/book', [\App\Http\Controllers\TicketSeller\BookingController::class, 'bookTicket'])->name('ticket-seller.booking.book');
    Route::get('/search', [\App\Http\Controllers\TicketSeller\BookingController::class, 'searchBookings'])->name('ticket-seller.search');
    Route::post('/search', [\App\Http\Controllers\TicketSeller\BookingController::class, 'searchBookings'])->name('ticket-seller.search.post');
    Route::get('/search/quick/{type}', [\App\Http\Controllers\TicketSeller\BookingController::class, 'quickSearchBookings'])->name('ticket-seller.search.quick');
    Route::get('/print', [\App\Http\Controllers\TicketSeller\BookingController::class, 'printTickets'])->name('ticket-seller.print');
    Route::post('/print', [\App\Http\Controllers\TicketSeller\BookingController::class, 'printTickets'])->name('ticket-seller.print.post');
    Route::get('/print/ticket/{id}', [\App\Http\Controllers\TicketSeller\BookingController::class, 'getTicketDetails'])->name('ticket-seller.print.details');
    Route::get('/print/ticket/{id}/print', [\App\Http\Controllers\TicketSeller\BookingController::class, 'printTicket'])->name('ticket-seller.print.ticket');
    Route::get('/cash-report', [\App\Http\Controllers\TicketSeller\BookingController::class, 'cashReport'])->name('ticket-seller.cash-report');
    Route::post('/cash-report', [\App\Http\Controllers\TicketSeller\BookingController::class, 'cashReport'])->name('ticket-seller.cash-report.post');
});

// API routes for frontend JavaScript
Route::get('/api/seat-classes', function () {
    return \App\Models\SeatClass::select('id', 'class_code', 'class_name')->get();
})->name('api.seat-classes');