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
		Route::resource('blocks', 'BlocksLandingPageController')->except('show');
		Route::post('blocks/copyedit/{id}', 'BlocksLandingPageController@copyedit')->name('blocks.copyedit');
		Route::get('blocks/blockscss', 'BlocksLandingPageController@blockscss')->name('blocks.blockscss');
		Route::post('blocks/updateblockscss', 'BlocksLandingPageController@updateblockscss')->name('blocks.updateblockscss');

		Route::resource('blockscategories', 'BlocksCategoriesController')->except('show');  
	});

});


