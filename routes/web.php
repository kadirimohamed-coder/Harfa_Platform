<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CraftsmanController;
use App\Http\Controllers\Admin\AdminController;

// ═══════════════════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════════════════
Route::get('/',          [PublicController::class, 'home'])->name('home');
Route::get('/about',     [PublicController::class, 'about'])->name('about');
Route::get('/pricing',   [PublicController::class, 'pricing'])->name('pricing');
Route::get('/find-work', [PublicController::class, 'findWork'])->name('find-work');

// Categories
Route::get('/categories/{category}', [PublicController::class, 'categoryShow'])->name('categories.show');

// Craftsmen browse
Route::get('/craftsmen',        [PublicController::class, 'craftsmenIndex'])->name('craftsmen.index');
Route::get('/craftsmen/{craftsman}', [PublicController::class, 'craftsmenShow'])->name('craftsmen.show');

// ═══════════════════════════════════════════════════════
// AUTH ROUTES
// ═══════════════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Profile (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile',           [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile',          [AuthController::class, 'updateProfile'])->name('profile.update');
});

// ═══════════════════════════════════════════════════════
// CLIENT ROUTES
// ═══════════════════════════════════════════════════════-
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {

    Route::get('/',              [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings',      [ClientController::class, 'bookings'])->name('bookings');
    Route::get('/reviews',       [ClientController::class, 'reviews'])->name('reviews');
    Route::get('/billing',       [ClientController::class, 'billing'])->name('billing');

    // Booking flow
    Route::get('/book/{craftsman}',  [ClientController::class, 'bookForm'])->name('book.form');
    Route::post('/book/{craftsman}', [ClientController::class, 'bookStore'])->name('book.store');

    // Reviews
    Route::get('/review/{booking}',  [ClientController::class, 'reviewForm'])->name('review.form');
    Route::post('/review/{booking}', [ClientController::class, 'reviewStore'])->name('review.store');

    // Job gigs
    Route::get('/post-job',          [ClientController::class, 'postJobForm'])->name('post-job');
    Route::post('/gigs',             [ClientController::class, 'gigStore'])->name('gigs.store');
    Route::get('/gigs/{gig}',        [ClientController::class, 'gigShow'])->name('gigs.show');

    // Inbox / messaging
    Route::get('/inbox',             [ClientController::class, 'inbox'])->name('inbox');
    Route::get('/inbox/{user}',      [ClientController::class, 'inboxChat'])->name('inbox.chat');
    Route::post('/inbox/send',       [ClientController::class, 'inboxSend'])->name('inbox.send');
});

// ═══════════════════════════════════════════════════════
// CRAFTSMAN ROUTES
// ═══════════════════════════════════════════════════════
Route::middleware(['auth', 'role:craftsman'])->prefix('craftsman')->name('craftsman.')->group(function () {

    Route::get('/',              [CraftsmanController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile',       [CraftsmanController::class, 'profile'])->name('profile');
    Route::post('/profile',      [CraftsmanController::class, 'updateProfile'])->name('profile.update');

    Route::get('/categories',        [CraftsmanController::class, 'categories'])->name('categories');
    Route::post('/categories',       [CraftsmanController::class, 'updateCategories'])->name('categories.update');

    Route::get('/bookings',          [CraftsmanController::class, 'bookings'])->name('bookings');
    Route::post('/bookings/{booking}',[CraftsmanController::class, 'updateBooking'])->name('bookings.update');

    Route::get('/reviews',           [CraftsmanController::class, 'reviews'])->name('reviews');

    Route::get('/earnings',          [CraftsmanController::class, 'earnings'])->name('earnings');

    Route::get('/billing',           [CraftsmanController::class, 'billing'])->name('billing');
    Route::post('/billing/buy',      [CraftsmanController::class, 'buyPoints'])->name('billing.buy');

    // Availability toggle
    Route::post('/availability',     [CraftsmanController::class, 'toggleAvailability'])->name('availability.toggle');

    // Inbox
    Route::get('/inbox',             [CraftsmanController::class, 'inbox'])->name('inbox');
    Route::get('/inbox/{user}',      [CraftsmanController::class, 'inboxChat'])->name('inbox.chat');
    Route::post('/inbox/send',       [CraftsmanController::class, 'inboxSend'])->name('inbox.send');

    // Gigs — apply
    Route::get('/gigs/{gig}',        [CraftsmanController::class, 'gigShow'])->name('gigs.show');
    Route::post('/gigs/{gig}/apply', [CraftsmanController::class, 'gigApply'])->name('gigs.apply');
});

// ═══════════════════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════════════════
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/',            [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get('/users',               [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle',[AdminController::class, 'toggleUser'])->name('users.toggle');
    Route::delete('/users/{user}',     [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Craftsmen
    Route::get('/craftsmen',                     [AdminController::class, 'craftsmen'])->name('craftsmen');
    Route::post('/craftsmen/{craftsman}/toggle', [AdminController::class, 'toggleCraftsman'])->name('craftsmen.toggle');

    // Categories
    Route::get('/categories',              [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories',             [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}',   [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}',[AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Bookings
    Route::get('/bookings',                [AdminController::class, 'bookings'])->name('bookings');
    Route::post('/bookings/{booking}',     [AdminController::class, 'updateBooking'])->name('bookings.update');

    // Reviews
    Route::get('/reviews',                 [AdminController::class, 'reviews'])->name('reviews');
    Route::delete('/reviews/{review}',     [AdminController::class, 'destroyReview'])->name('reviews.destroy');

    // Gigs
    Route::get('/gigs',                    [AdminController::class, 'gigs'])->name('gigs');
    Route::post('/gigs/{gig}/toggle',      [AdminController::class, 'toggleGig'])->name('gigs.toggle');
    Route::delete('/gigs/{gig}',           [AdminController::class, 'destroyGig'])->name('gigs.destroy');

    // Payments / finance
    Route::get('/payments',                [AdminController::class, 'payments'])->name('payments');
});
