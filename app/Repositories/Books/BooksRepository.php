<?php

namespace App\Repositories\Books;

use App\Repositories\Books\Iterators\BookIterator;
use App\DTO\BookDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BooksRepository
{
    public function getBooks($startDate, $endDate, $year = null, $lang = null): \Illuminate\Support\Collection
    {
        $query = DB::table('books')
            ->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)]); // [new Carbon($startDate), new Carbon($endDate)]
        $booksCollection = collect($query->get());

        if ($year) {
            $yearQuery = DB::table('books')
                ->whereYear('created_at', $year)
                ->get();
            $booksCollection = $booksCollection->concat($yearQuery);
        }

        if ($lang) {
            $langQuery = DB::table('books')
                ->where('lang', $lang)
                ->get();
            $booksCollection = $booksCollection->concat($langQuery);
        }

        return $booksCollection;
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
            ->update(
                [
                    'name' => $bookDTO->getName(),
                    'year' => $bookDTO->getYear(),
                    'lang' => $bookDTO->getLang(),
                    'pages' => $bookDTO->getPages(),
                    'updated_at' => $bookDTO->getUpdatedAt(),
                ]
            );

        return $updated;
    }

    public function deleteBook($id): bool
    {
        $deleted = DB::table('books')->delete($id);
        return $deleted > 0;
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
