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

Route::get('/','SocialHome@login');
Route::post('/authenticate', 'SocialHome@authenticateLogin')->withoutMiddleware(['authcustome']);
Route::get('/register', 'SocialHome@register')->withoutMiddleware(['authcustome']);
Route::post('/registerNewUser', 'SocialHome@registerNewUser');
Route::get('/dashboard', 'SocialHome@dashBoardPage');
Route::any('/ajax', 'SocialHome@ajax');
Route::any('/submit-status', 'SocialHome@submitStatus');
