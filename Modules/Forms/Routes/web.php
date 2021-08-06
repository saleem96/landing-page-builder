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

if (Module::find('Saas')) {
	Route::group(['middleware' => ['Modules\Saas\Http\Middleware\Billing','throttle:60,1']], function() {
		Route::post('form-submission/{item}', 'FormDataController@submission')->name('form-submission');
	});
}
else{
	Route::group(['middleware' => ['throttle:60,1']], function() {
    	Route::post('form-submission/{item}', 'FormDataController@submission')->name('form-submission');
	});
}

Route::prefix('leads')->group(function() {
	Route::get('/', 'FormDataController@index')->name('leads.index');
	Route::get('edit/{item}', 'FormDataController@edit')->name('leads.edit');
	Route::post('update/{item}', 'FormDataController@update')->name('leads.update');

	Route::delete('delete/{item}', 'FormDataController@delete')->name('leads.delete');
	
	if (Module::find('Saas')) {
		
		Route::group(['middleware' => ['Modules\Saas\Http\Middleware\Billing']], function() {
			Route::get('exportcsv', 'FormDataController@exportcsv')->name('leads.exportcsv');
		});
		
	}
	else{
		Route::get('exportcsv', 'FormDataController@exportcsv')->name('leads.exportcsv');
	}
	
});
