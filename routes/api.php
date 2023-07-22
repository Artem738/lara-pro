<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;


Route::post('login', [UserController::class, 'login']);

Route::middleware(["auth:api"])->group(
    function () {
        //Всі роути тут потребують авторизованого користувача, перевіряє ключ bearer у тоукені
        Route::get('books/chunk-test', [BooksController::class, 'chunkTest']);

        Route::apiResource('user', UserController::class)->parameters(
            [
                'user' => 'id',
            ]

        );
    }
);
// але можно просто додати до роута ->middleware('auth');


Route::apiResource('books', BooksController::class)->parameters(
    [
        'books' => 'id',
    ]
);


Route::apiResource('books', BooksController::class)->parameters(
    [
        'books' => 'id',
    ]
);


Route::apiResource('categories', CategoriesController::class)->parameters(
    [
        'categories' => 'id',
    ]
);



//Route::get('/books', [BooksController::class, 'index']); // http://lara-pro.loc/api/books/
//Route::post('/books', [BooksController::class, 'store']);  // curl -X POST -d "name=Book Name&author=Author Name1&year=2022&countPages=2001" http://lara-pro.loc/api/books
//Route::get('/books/{id}', [BooksController::class, 'show']); // http://lara-pro.loc/api/books/2
//Route::put('/books/{id}', [BooksController::class, 'update']);  //  curl -X PUT -d "name=Updated Book&author=Updated Author&year=2022&countPages=300" http://lara-pro.loc/api/books/1
//Route::delete('/books/{id}', [BooksController::class, 'destroy']); // curl -X DELETE http://lara-pro.loc/api/books/123
