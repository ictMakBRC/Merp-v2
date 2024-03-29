<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\UserManagement\UserProfileComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::get('user/account', UserProfileComponent::class)->name('user.account')->middleware('auth', 'twofactor','userConsent');

Route::get('lang/{locale}', function ($locale) {
    if (array_key_exists($locale, config('languages'))) {
        Session::put('locale', $locale);
    }

    return redirect()->back();
})->name('lang');

Route::get('/2fa/verify', [AuthenticatedSessionController::class, 'twoFactorAuthentication'])->middleware('auth')->name('two-factor-auth');
Route::group(['middleware' => ['auth',  'suspended_user','twofactor']], function () {
    Route::get('/home', function () {
        return view('home');
    })->middleware(['auth', 'verified'])->name('home');

    Route::group(['middleware' => ['userConsent']], function () {
        Route::group(['prefix' => 'admin'], function () {
            //User Management
            Route::get('/manage', function () {
                return view('admin.dashboard');
            })->middleware(['auth', 'verified'])->name('admin-dashboard');

            require __DIR__.'/user_mgt.php';
        });
        require __DIR__.'/hr.php';
        require __DIR__.'/human_resource.php';
        require __DIR__.'/inventory.php';
        require __DIR__.'/assets.php';
        require __DIR__.'/finance.php';
        require __DIR__.'/procurement.php';
        require __DIR__.'/grants.php';
        require __DIR__.'/documents.php';
    });
});

require __DIR__.'/auth.php';
