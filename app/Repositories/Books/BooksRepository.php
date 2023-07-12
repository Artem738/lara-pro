<?php

namespace App\Repositories\Books;

use App\Repositories\Books\Iterators\BookIterator;
use App\DTO\BookDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BooksRepository
{
    public function getBook($bookDTO)
    {
        // Логика выборки книг с учетом переданных параметров
        // Возвращаем Iterator объект
    }

    public function store(BookDTO $bookDTO): int
    {
        $bookId = DB::table('books')->insertGetId(
            [
                'name' => $bookDTO->getName(),
                'year' => $bookDTO->getYear(),
                'lang' => $bookDTO->getLang(),
                'pages' => $bookDTO->getPages(),
                'created_at' => $bookDTO->getCreatedAt(),
                'updated_at' => $bookDTO->getUpdatedAt(),
            ]
        );

        return $bookId;
    }


    public function updateBook($id, $bookDTO)
    {
        // Логика обновления книги
        // Возвращаем обновленный объект книги
    }

    public function deleteBook($id)
    {
        // Логика удаления книги
    }

    public function getBookById(int $id): BookIterator
    {
        $bookData = DB::table('books')
            ->where('id', '=', $id)
            ->first();
        //var_dump($book); exit();
        return new BookIterator($bookData);
    }

}
