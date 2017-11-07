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
Route::post('/postNewParticipantPage1Data','MainController@postNewParticipantPage1Data');
Route::get('/openNewParticipantPage2','MainController@openNewParticipantPage2');
Route::post('/registerNewParticipant','MainController@registerNewParticipant');
Route::get('/openSendPicture/{id}','MainController@openSendPicture');
Route::get('/openAllPictures','MainController@openAllPictures');



Route::group(['middleware' => 'auth'], function () {
	Route::get('/deleteAVote/{id}','MainController@deleteAVote');
	Route::get('/voteForPicture/{id}','MainController@voteForPicture');
	Route::get('/openPicturesParticipent','MainController@openPicturesParticipent');
	
	
});

Route::group(['middleware' => 'admin'], function () {
	Route::get('/allParticipants/','MainController@allParticipants');
	Route::get('/deleteAUser/{id}','MainController@deleteAUser');
	Route::get('/setUserAsAdmin/{id}','MainController@setUserAsAdmin');
	Route::get('/setAdminAsNormalUser/{id}','MainController@setAdminAsNormalUser');
	
	
});


Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
