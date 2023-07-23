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
            ->select(
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
                'categories.updated_at as category_updated_at'
            )
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->where(
                function ($query) use ($bookIndexDTO) {
                    $query->whereBetween(
                        'books.created_at', [
                                              Carbon::parse($bookIndexDTO->getStartDate()),
                                              Carbon::parse($bookIndexDTO->getEndDate())
                                          ]
                    )
                        ->orWhere('books.year', '=', $bookIndexDTO->getYear())
                        ->orWhere('books.lang', '=', $bookIndexDTO->getLang());
                }
            )
            ->where('books.id', '>', $bookIndexDTO->getLastId())
            ->limit($bookIndexDTO->getLimit()->value)
            ->get();

        return $booksData->map(
            function ($bookData) {
                return new BookIterator($bookData);
            }
        );
    }

    //->orderBy('books.id', 'desc')
    //->inRandomOrder('books.name')  // Time: 5564ms -При 1.5М
    //->inRandomOrder('year')  //  5101ms  -При 1.5М
    // ->orderBy('books.year') //Time: 41144ms (41 s 144 ms); // - є індекс
    // ->orderBy('books.name') // Time: 43180ms   -При 1.5М  нема індексу, незначна різниці...хз..
    // ->orderBy('name','asc') // 39248ms -При 1.5М
    //->inRandomOrder('books.id') // 5154ms  -При 1.5М
    // Щось незначний результат, не до кінці зрозуміло... Напевно неправильний тест.

    public function chunkTestUpdateBookNames(): void
    {
        // Переїзжаємо у консольні команди для цього
        echo ("404 - under construction"); die();
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
