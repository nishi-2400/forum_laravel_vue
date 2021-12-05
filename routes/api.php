<?php

use Illuminate\Http\Request;

//　認証済み 
Route::middleware('auth:api')->group(function () {
    Route::get('/contacts', 'ContactsController@index');
    Route::get('/contacts/{contact}', 'ContactsController@show');
    Route::patch('/contacts/{contact}', 'ContactsController@update');
    Route::post('/contacts', 'ContactsController@store');
    Route::delete('/contacts/{contact}', 'ContactsController@destroy');

    Route::get('/birthdays', 'BirthdaysController@index');
    Route::post('/search', 'SearchController@index');
});
