<?php

namespace App\Repositories\Books;

use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\DTO\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BooksRepository
{
    public function getBooksBetweenCreatedAtAndWhereLangAndYear(BookIndexDTO $bookIndexDTO): Collection //of iterators
    {
        $query = DB::table('books')
            ->whereBetween(
                'created_at', [
                                Carbon::parse($bookIndexDTO->getStartDate()),
                                Carbon::parse($bookIndexDTO->getEndDate())
                            ]
            );
        if ($bookIndexDTO->getYear()) {
            $query->orWhereYear('created_at', $bookIndexDTO->getYear());
        }
        if ($bookIndexDTO->getLang()) {
            $query->orWhere('lang', $bookIndexDTO->getLang()->value);
        }
        $booksData = collect(
            $query->
            select(
                [
                    'id',
                    'name',
                    'year',
                    'lang',
                    'pages',
                    'created_at',
                    'updated_at',
                   // 'category_id',
                ]
            )
                ->get()
        );

        $books = collect();

        foreach ($booksData as $bookData) {
            $bookIterator = new BookIterator($bookData);
            $books->push($bookIterator);
        }
        return $books;
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

    public function updateBook(BookUpdateDTO $bookUpdateDTO): bool
    {
        $updateStatus = DB::table('books')
            ->where('id', $bookUpdateDTO->getId())
            ->update(
                [
                    'name' => $bookUpdateDTO->getName(),
                    'year' => $bookUpdateDTO->getYear(),
                    'lang' => $bookUpdateDTO->getLang(),
                    'pages' => $bookUpdateDTO->getPages(),
                    'updated_at' => $bookUpdateDTO->getUpdatedAt(),
                ]
            );

        return $updateStatus;
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
            ->select(
                ['id',
                    'name',
                    'year',
                    'lang',
                    'pages',
                    'created_at',
                    'updated_at'
                ]
            )
            ->first();
        return new BookIterator($bookData);
    }

}
