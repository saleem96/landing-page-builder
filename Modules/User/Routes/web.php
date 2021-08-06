<?php

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

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Login with social accounts
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.social');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('login.callback');

//Payments
Route::get('/payments', 'UserController@accountSettings');
Route::post('/payments', 'PaymentController@store')->name('payments-new');
Route::get('/thankyou', 'PaymentController@thankyou')->name('thanks');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('accountsettings', 'UserController@accountSettings')->name('accountsettings.index');
    Route::put('accountsettings', 'UserController@accountSettingsUpdate')->name('accountsettings.update');
    Route::put('paymentSettings', 'UserController@paymentSettingsUpdate')->name('paymentSettings.update');
    Route::get('paymentsettings', 'UserController@paymentSettings')->name('paymentsettings.index');
    Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
        // Users
        Route::resource('users', 'UserController')->except('show');

    });
    Route::get('/{order?}', [
        'name' => 'PayPal Express Checkout',
        'as' => 'app.home',
        'uses' => 'PayPalController@form',
    ]);
    
    Route::post('/checkout/payment/{order}/paypal', [
        'name' => 'PayPal Express Checkout',
        'as' => 'checkout.payment.paypal',
        'uses' => 'PayPalController@checkout',
    ]);
    
    Route::get('/paypal/checkout/{order}/completed', [
        'name' => 'PayPal Express Checkout',
        'as' => 'paypal.checkout.completed',
        'uses' => 'PayPalController@completed',
    ]);
    
    Route::get('/paypal/checkout/{order}/cancelled', [
        'name' => 'PayPal Express Checkout',
        'as' => 'paypal.checkout.cancelled',
        'uses' => 'PayPalController@cancelled',
    ]);
    
    Route::post('/webhook/paypal/{order?}/{env?}', [
        'name' => 'PayPal Express IPN',
        'as' => 'webhook.paypal.ipn',
        'uses' => 'PayPalController@webhook',
    ]);
});