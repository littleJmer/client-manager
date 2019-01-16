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

// Simple route
Route::get('/', function() { return redirect('login'); });

// Auth routes... override
Auth::routes();

// App routes
Route::get('/app/dashboard', 'AppController@dashboard')->name('app.dashboard');
Route::get('/app/client/create', 'AppController@client_create')->name('app.client-create');
Route::get('/app/client/edit/{id}', 'AppController@client_edit')->name('app.client-edit');
Route::get('/app/dashboard/import-csv', 'AppController@import_csv')->name('app.import-csv');
