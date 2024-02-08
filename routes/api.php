<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::apiResource('books', \App\Http\Controllers\BookController::class);
Route::apiResource('tags', \App\Http\Controllers\TagController::class);
Route::apiResource('authors', \App\Http\Controllers\AuthorController::class);
