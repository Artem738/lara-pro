<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;


Route::apiResource('books', BooksController::class);

//Route::get('/books', [BooksController::class, 'index']); // http://lara-pro.loc/api/books/
//Route::post('/books', [BooksController::class, 'store']);  // curl -X POST -d "name=Book Name&author=Author Name1&year=2022&countPages=2001" http://lara-pro.loc/api/books
//Route::get('/books/{id}', [BooksController::class, 'show']); // http://lara-pro.loc/api/books/2
//Route::put('/books/{id}', [BooksController::class, 'update']);  //  curl -X PUT -d "name=Updated Book&author=Updated Author&year=2022&countPages=300" http://lara-pro.loc/api/books/1
//Route::delete('/books/{id}', [BooksController::class, 'destroy']); // curl -X DELETE http://lara-pro.loc/api/books/123
