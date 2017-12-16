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

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Auth::routes();

Route::get('/search', 'SearchController@sendQuery')->name('search');
Route::get('bookmark/{uri}', 'SearchController@bookmark')->name('bookmark')->middleware('auth');
Route::get('saved-recipes', 'SearchController@getSavedRecipes')->name('saved')->middleware('auth');

