<?php

use Illuminate\Support\Facades\Route;


Route::get('/visits', 'VisitController@index');
Route::get('/visits/{visit}', 'VisitController@show');
Route::post('/visits', 'VisitController@store');
Route::put('/visits/{visit}', 'VisitController@update');
Route::delete('/visits/{visit}', 'VisitController@destroy');

Route::get('/members', 'MemberController@index');
Route::post('/members', 'MemberController@store');
Route::put('/members/{member}', 'MemberController@update');
Route::delete('/members/{member}', 'MemberController@destroy');
