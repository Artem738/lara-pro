<?php

namespace App\Repositories\Books;

use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\DTO\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BooksRepository
{
    public function getBooks(BookIndexDTO $bookIndexDTO): \Illuminate\Support\Collection
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
            $query->orWhere('lang', $bookIndexDTO->getLang());
        }

        return collect($query->get());
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
        //TODO:Доробити вибірку тільки потрібних даних.
        $bookData = DB::table('books')
            ->where('id', '=', $id)
            ->first();
        //var_dump($book); exit();
        return new BookIterator($bookData);
    }

}
