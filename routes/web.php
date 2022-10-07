<?php

use App\Http\Controllers\EmailController;
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

Route::get('/email', [EmailController::class, 'getEmail']);
Route::post('/email', [EmailController::class, 'postCreateEmail']);

/*

POST 127.0.0.1:8080/email
{
    email: 'moorlagt@gmail.com',
    message: 'Hey Bro!',
    attached: some file
    attached_filename: 'helloworld.text'
}
*/
