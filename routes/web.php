<?php

use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', function () {
    return view('pages.beranda');
});

Route::get('/tentang', function () {
    return view('pages.tentang');
});

Route::get('/cara-melapor', function () {
    return view('pages.cara-melapor');
});

Route::get('/daftar-pengaduan', function () {
    return view('pages.daftar-pengaduan');
});

// Autentikasi
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

// Dashboard (Protected via JS & API)
Route::get('/dashboard', function () {
    return view('dashboard.pengguna');
});

Route::get('/dashboard/admin', function () {
    return view('dashboard.admin');
});

Route::get('/dashboard/admin/users', function () {
    return view('admin.users');
});

Route::get('/dashboard/admin/settings', function () {
    return view('admin.settings');
});
