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
Route::middleware('auth')->group(function () {
	Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
		// Settings
		Route::get('/', 'SettingsController@index')->name('index');
		Route::get('localization', 'SettingsController@localization')->name('localization');
		Route::get('email', 'SettingsController@email')->name('email');
		Route::get('integrations', 'SettingsController@integrations')->name('integrations');
		// Save settings
        Route::post('general/{group?}', 'SettingsController@update')->name('general.update');

		Route::get('/cacheclear', 'SettingsController@cacheClear')->name('cacheclear');
		Route::get('/syncmissingtranslationkeys', 'SettingsController@syncMissingTranslationKeys')->name('syncMissingTranslationKeys');
		Route::get('/updateversion', 'SettingsController@updateVersion')->name('updateVersion');

	});
});