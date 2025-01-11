<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('filament.admin.auth.login');
});

//redirect to admin
// Route::get('/admin', function () {
//     return redirect()->route('filament.pages.dashboard.index');
// });
