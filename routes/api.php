<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('detail/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api'
], function ($router) {
    Route::get('redirect', 'UserController@redirect')->name('redirect');
    Route::post('login', 'UserController@login')->name('login');
    Route::post('register', 'UserController@register')->name('register');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api'
], function ($router) {
    Route::get('candidate', 'CandidateController@index')->name('candidate.index');
    Route::get('candidate/{id}', 'CandidateController@show')->name('candidate.show');
    Route::post('candidate', 'CandidateController@store')->name('candidate.store');
    Route::put('candidate/{id}', 'CandidateController@update')->name('candidate.update');
    Route::delete('candidate/{id}', 'CandidateController@destroy')->name('candidate.delete');
});
