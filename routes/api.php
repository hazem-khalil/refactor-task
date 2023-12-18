<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\MemberController;


Route::get('/visits', [VisitController::class, 'index']);
Route::get('/visits/{visit}', [VisitController::class, 'show']);
Route::post('/visits', [VisitController::class, 'store']);
Route::put('/visits/{visit}', [VisitController::class, 'update']);
Route::delete('/visits/{visit}', [VisitController::class, 'destroy']);

Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::put('/members/{member}', [MemberController::class, 'update']);
Route::delete('/members/{member}', [MemberController::class, 'destroy']);
