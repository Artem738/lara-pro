<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;



Route::get('/books', [BookController::class, 'index']); // http://lara-pro.loc/api/books/
Route::post('/books', [BookController::class, 'store']);  // curl -X POST -d "name=Book Name&author=Author Name1&year=2022&countPages=2001" http://lara-pro.loc/api/books
Route::get('/books/{id}', [BookController::class, 'show']); // http://lara-pro.loc/api/books/2
Route::put('/books/{id}', [BookController::class, 'update']);  //  curl -X PUT -d "name=Updated Book&author=Updated Author&year=2022&countPages=300" http://lara-pro.loc/api/books/1
Route::delete('/books/{id}', [BookController::class, 'destroy']); // curl -X DELETE http://lara-pro.loc/api/books/123
