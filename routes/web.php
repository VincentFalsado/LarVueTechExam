<?php

use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

// Dashboard
Route::get('/home', [App\Http\Controllers\UsersManagerController::class, 'index'])->name('home');

// User Authentication Routes
Route::get('/login','App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::post('/validate/user','App\Http\Controllers\Auth\LoginController@doValidate');

Route::get('/register','App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::post('/register/user','App\Http\Controllers\Auth\RegisterController@doCreate');

// Data Routes
Route::get('/roles','App\Http\Controllers\UsersManagerController@roles');
Route::get('/users','App\Http\Controllers\UsersManagerController@users');

// Users CRUD Routes
Route::post('/user/add','App\Http\Controllers\UsersManagerController@store');
Route::delete('/user/delete/{id}','App\Http\Controllers\UsersManagerController@destroy');
Route::post('/user/restore/{id}','App\Http\Controllers\UsersManagerController@restore');
Route::put('/user/update/{id}','App\Http\Controllers\UsersManagerController@update');

// Roles CRUD Routes
Route::post('/role/add','App\Http\Controllers\RolesManagerController@store');
Route::delete('/role/delete/{id}','App\Http\Controllers\RolesManagerController@destroy');
Route::post('/role/restore/{id}','App\Http\Controllers\RolesManagerController@restore');
Route::put('/role/update/{id}','App\Http\Controllers\RolesManagerController@update');

Route::get('/authUser','App\Http\Controllers\ClientController@getAuth');

