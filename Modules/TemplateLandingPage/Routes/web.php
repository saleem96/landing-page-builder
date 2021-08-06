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
	Route::get('alltemplates/{id?}', 'TemplateLandingPageController@getAllTemplate')->name('alltemplates');

	Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {
	
		Route::resource('templates', 'TemplateLandingPageController')->except('show');
		Route::resource('categories', 'CategoriesTemplateController')->except('show');
		Route::resource('groupcategories', 'GroupCategoriesController')->except('show');

		Route::post('templates/uploadimage', 'TemplateLandingPageController@uploadImage')->name('templates.uploadimage');
	    Route::post('templates/deleteimage', 'TemplateLandingPageController@deleteImage')->name('templates.deleteimage');

		Route::post('templates/clone/{id}', 'TemplateLandingPageController@clone')->name('templates.clone');
		// Builder template
		Route::get('templates/builder/{id}/{type?}', 'TemplateLandingPageController@builder')->name('templates.builder');
		// Load builder
		Route::post('templates/update-builder/{id}/{type?}', 'TemplateLandingPageController@updateBuilder')->name('templates.updateBuilder');
		Route::get('templates/load-builder/{id}/{type?}', 'TemplateLandingPageController@loadBuilder')->name('templates.loadBuilder');
	});
});