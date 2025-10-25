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
Route::post('/search-result', [TrainSearchController::class, 'search'])->name('search.trains.post');

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
    Route::get('/trains', function () {
        return view('admin.trains');
    })->name('admin.trains');
    Route::get('/stations', function () {
        return view('admin.stations');
    })->name('admin.stations');
    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');
    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
});

// Station Master routes
Route::middleware(['auth', 'role:station_master'])->prefix('station-master')->group(function () {
    Route::get('/schedule', function () {
        return view('station-master.schedule');
    })->name('station-master.schedule');
    Route::get('/delays', function () {
        return view('station-master.delays');
    })->name('station-master.delays');
    Route::get('/platforms', function () {
        return view('station-master.platforms');
    })->name('station-master.platforms');
    Route::get('/announcements', function () {
        return view('station-master.announcements');
    })->name('station-master.announcements');
});

// Ticket Seller routes
Route::middleware(['auth', 'role:ticket_seller'])->prefix('ticket-seller')->group(function () {
    Route::get('/booking', function () {
        return view('ticket-seller.booking');
    })->name('ticket-seller.booking');
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
