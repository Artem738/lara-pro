<?php

namespace App\Repositories\Books;

use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\DTO\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BooksRepository
{
    public function getBooksBetweenCreatedAtAndWhereLangAndYear(BookIndexDTO $bookIndexDTO): Collection //of iterators
    {
       // echo($bookIndexDTO->getLastId()); die();

        $booksData = DB::table('books')
            ->where(function ($query) use ($bookIndexDTO) {
                $query->whereBetween('books.created_at', [
                    Carbon::parse($bookIndexDTO->getStartDate()),
                    Carbon::parse($bookIndexDTO->getEndDate())
                ]);

                if ($bookIndexDTO->getYear()) {
                    $query->orWhereYear('books.created_at', $bookIndexDTO->getYear());
                }

                if ($bookIndexDTO->getLang()) {
                    $query->orWhere('books.lang', $bookIndexDTO->getLang()->value);
                }
            })
            ->where('books.id', '>=', $bookIndexDTO->getLastId())
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->select([
                         'books.id',
                         'books.name',
                         'books.year',
                         'books.lang',
                         'books.pages',
                         'books.created_at',
                         'books.updated_at',
                         'category_id',
                         'categories.name as category_name',
                         'categories.created_at as category_created_at',
                         'categories.updated_at as category_updated_at',
                     ])
            //->orderBy('books.id', 'desc')
            ->limit($bookIndexDTO->getLimit())
            ->get();

        return $booksData->map(function ($bookData) {
            return new BookIterator($bookData);
        });
    }

    public function store(BookStoreDTO $bookStoreDTO): int
    {
        $bookId = DB::table('books')->insertGetId(
            [
                'name' => $bookStoreDTO->getName(),
                'year' => $bookStoreDTO->getYear(),
                'lang' => $bookStoreDTO->getLang(),
                'pages' => $bookStoreDTO->getPages(),
                'category_id' => $bookStoreDTO->getCategoryId(),
                'created_at' => $bookStoreDTO->getCreatedAt(),
                'updated_at' => $bookStoreDTO->getUpdatedAt(),
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
                    'category_id' => $bookUpdateDTO->getCategoryId(),
                    'updated_at' => $bookUpdateDTO->getUpdatedAt(),
                ]
            );

        return $updateStatus;
    }

    public function deleteBook($id): bool
    {
        $deleted = DB::table('books')->where('id', $id)->delete();
        return $deleted > 0;
    }

    public function getBookById(int $id): BookIterator
    {

        $bookData = DB::table('books')
            ->where('books.id', '=', $id)
            ->select(
                [
                    'books.id',
                    'books.name',
                    'books.year',
                    'books.lang',
                    'books.pages',
                    'books.created_at',
                    'books.updated_at',
                    'category_id',
                    'categories.name as category_name',
                    'categories.created_at as category_created_at',
                    'categories.updated_at as category_updated_at',
                ]
            )
                ->join('categories', 'categories.id', '=', 'books.category_id')
                ->get()
            ->first();
        if ($bookData === null) {
            throw new Exception('Book not found');
        }
        return new BookIterator($bookData);
    }
}
