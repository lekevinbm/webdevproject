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

Route::get('/','MainController@index');
Route::get('/newParticipant','MainController@openNewParticipant');
Route::post('/registerNewParticipant','MainController@registerNewParticipant');
Route::get('/openSendPicture/{id}','MainController@openSendPicture');
Route::get('/deleteAVote/{id}','MainController@deleteAVote');
Route::get('/voteForPicture/{id}','MainController@voteForPicture');
Route::get('/allParticipants/','MainController@allParticipants');

Auth::routes();
