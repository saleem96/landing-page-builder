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

use App\Http\Middleware\Publish;

Route::middleware('auth')->group(function () {

	Route::get('dashboard', 'LandingPageController@dashboard')->name('dashboard');

	Route::post('uploadimage', 'LandingPageController@uploadImage');
    Route::post('deleteimage', 'LandingPageController@deleteImage');
    Route::post('searchIcon', 'LandingPageController@searchIcon');
	
    Route::prefix('intergration')->group(function() {
        
    	Route::post('lists/{type}', 'IntergrationController@lists');
    	Route::post('mergefields/{type}', 'IntergrationController@mergefields');
    	
    	Route::post('test-connection/{type}', 'IntergrationController@testConnection');
    	
    });

	
	
	Route::prefix('landingpages')->group(function() {

		Route::get('/', 'LandingPageController@index')->name('landingpages.index');
		Route::get('/transactions', 'LandingPageController@transactions')->name('landingpages.trans');
		
		Route::post('clone/{id}', 'LandingPageController@clone')->name('landingpages.clone');


		Route::get('frame-main-page/{id}', 'LandingPageController@frameMainPage')->name('landingpages.frame-main-page');
		Route::get('frame-thank-you-page/{id}', 'LandingPageController@frameThankYouPage')->name('landingpages.frame-thank-you-page');
		Route::post('get-template-json/{code}', 'LandingPageController@getTemplateJson');

		Route::get('preview-template/{id}', 'LandingPageController@previewTemplate')->name('landingpages.preview');
		Route::get('builder/{code}/{type?}', 'LandingPageController@builder')->name('landingpages.builder');
		Route::get('trashed', 'LandingPageController@trashed')->name('landingpages.trashed');
		Route::post('save', 'LandingPageController@save')->name('landingpages.save');
		// Load builder
		Route::post('update-builder/{item}/{type?}', 'LandingPageController@updateBuilder')->name('landingpages.updateBuilder');
		Route::get('load-builder/{item}/{type?}', 'LandingPageController@loadBuilder')->name('landingpages.loadBuilder');
		// Delete
		Route::post('delete/{item}', 'LandingPageController@delete')->name('landingpages.delete');
		Route::get('setting/{item}', 'LandingPageController@setting')->name('landingpages.setting');
		Route::post('setting-update/{item}', 'LandingPageController@settingUpdate')
		->name('landingpages.settings.update')->middleware(Publish::class);

	});
	
	
	
});