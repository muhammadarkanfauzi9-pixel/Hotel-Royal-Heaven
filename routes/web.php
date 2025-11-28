<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\PemesananController as AdminPemesananController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Member\KamarController as MemberKamarController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

use App\Http\Controllers\Member\PemesananController as MemberPemesananController;

// Landing page untuk user
Route::get('/', [MemberKamarController::class, 'index'])->name('landing');

// Home
Route::get('/home', fn() => view('home'))->name('home');

// Daftar kamar
Route::get('/daftarkamar', [MemberKamarController::class, 'index'])->name('daftarkamar');

// About
Route::get('/about', fn() => view('about'))->name('about');

// Admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::resource('kamar', KamarController::class)->except(['show']);
    Route::get('pemesanan', [AdminPemesananController::class, 'index'])->name('admin.pemesanan.index');
    Route::post('pemesanan/{pemesanan}/status', [AdminPemesananController::class, 'updateStatus'])->name('pemesanan.updateStatus');

    Route::get('admin/members', [AdminMemberController::class, 'index'])->name('admin.members.index');
    Route::get('admin/members/create', [AdminMemberController::class, 'create'])->name('admin.members.create');
    Route::post('admin/members', [AdminMemberController::class, 'store'])->name('admin.members.store');
    Route::get('admin/members/{member}/edit', [AdminMemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('admin/members/{member}', [AdminMemberController::class, 'update'])->name('admin.members.update');
    Route::delete('admin/members/{member}', [AdminMemberController::class, 'destroy'])->name('admin.members.destroy');
});

// Auth
Route::get('register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::get('login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('password/forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

// Member
Route::prefix('member')->name('member.')->middleware(['auth'])->group(function(){
    Route::get('pemesanan', [MemberPemesananController::class, 'index'])->name('pemesanan.index');

    Route::get('pemesanan/create', [MemberPemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('pemesanan', [MemberPemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('pemesanan/my', [MemberPemesananController::class, 'myBookings'])->name('pemesanan.my');
    Route::get('pemesanan/{pemesanan}', [MemberPemesananController::class, 'show'])->name('pemesanan.show');
    Route::delete('pemesanan/{pemesanan}/cancel', [MemberPemesananController::class, 'cancelBooking'])->name('pemesanan.cancel');
    Route::post('pemesanan/{pemesanan}/status', [MemberPemesananController::class, 'updateStatus'])->name('pemesanan.updateStatus');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('profile', [MemberProfileController::class, 'show'])->name('profile');
    Route::put('profile', [MemberProfileController::class, 'update'])->name('profile.update');
});

Route::get('member', [App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.index')->middleware('auth');

// Midtrans webhook
Route::post('/midtrans/notification', [MemberPemesananController::class, 'midtransNotification'])->name('midtrans.notification');
