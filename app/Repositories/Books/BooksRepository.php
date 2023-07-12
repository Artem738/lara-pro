<?php

namespace App\Repositories\Books;

use App\Repositories\Books\Iterators\BookIterator;
use App\DTO\BookDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BooksRepository
{
    public function getBooks($startDate, $endDate, $year, $lang)
    {
        $query = DB::table('books')
            ->whereBetween('created_at', [new Carbon($startDate), new Carbon($endDate)]);

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($lang) {
            $query->where('lang', $lang);
        }

        $books = $query->get();

        return $books;
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


    public function updateBook($id, BookDTO $bookDTO): bool
    {
        $updated = DB::table('books')
            ->where('id', $id)
            ->update([
                         'name' => $bookDTO->getName(),
                         'year' => $bookDTO->getYear(),
                         'lang' => $bookDTO->getLang(),
                         'pages' => $bookDTO->getPages(),
                         'updated_at' => $bookDTO->getUpdatedAt(),
                     ]);

        return $updated;
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
