<?php

use Devil\Solidprinciple\app\Services\SideBar;
use Illuminate\Support\Facades\Route;

Route::get('/admin/dashboard', function () {
    return view('backend.admin.dashboard');
});
Route::get('sidebar',fn ()=> SideBar::getSidebarMetadata())->name('sidebar');
Route::fallback(fn ()=> response()->json(['status'=>404,'message' => 'Page Not Found']));
