<?php

namespace App\Repositories\Books;

use App\Repositories\Books\Iterators\BookIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BooksRepository
{
    public function getBooks(BookIndexDTO $bookIndexDTO) //  : \Illuminate\Support\Collection
    {
        ///TODO: Переробити, щоб одразу через Ітератор записувалось, а не у контроллері.
        ///
        $query = DB::table('books')
            ->whereBetween('created_at', [Carbon::parse($bookIndexDTO->getStartDate()), Carbon::parse($bookIndexDTO->getEndDate())]); // [new Carbon($startDate), new Carbon($endDate)]
        $booksCollection = collect($query->get());

        if ($bookIndexDTO->getYear()) {
            $yearQuery = DB::table('books')
                ->whereYear('created_at', $bookIndexDTO->getYear())
                ->get();
            $booksCollection = $booksCollection->concat($yearQuery);
        }

        if ($bookIndexDTO->getLang()) {
            $langQuery = DB::table('books')
                ->where('lang', $bookIndexDTO->getLang())
                ->get();
            $booksCollection = $booksCollection->concat( $langQuery);
        }

        return $booksCollection;
    }


    public function store(BookStoreDTO $bookDTO): int
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


    public function updateBook($id, BookStoreDTO $bookDTO): bool
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
        //TODO:Доробити вибірку тільки потрібних даних.
        $bookData = DB::table('books')
            ->where('id', '=', $id)
            ->first();
        //var_dump($book); exit();
        return new BookIterator($bookData);
    }

}
