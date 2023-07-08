<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);  // curl -i -X POST -d "name=Book Name&author=Author Name1&year=2022&countPages=200" http://lara-pro.loc/api/books
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);  //  curl -X PUT -d "name=Updated Book&author=Updated Author&year=2022&countPages=300" http://lara-pro.loc/api/books/1
Route::delete('/books/{id}', [BookController::class, 'destroy']);
