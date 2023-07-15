<?php

//namespace App\DTO;
namespace App\Services;


use App\Repositories\Books\BooksRepository;
use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Exception;
use Illuminate\Support\Collection;


class BooksService
{
    public function __construct(
        protected BooksRepository $booksRepository
    ) {
    }

    public function getBooksForIndex(BookIndexDTO $bookIndexDTO): Collection
    {
        $booksData = $this->booksRepository->getBooksBetweenYearAndWhereLangAndYear($bookIndexDTO);

        $books = collect();

        foreach ($booksData as $bookData) {
            $bookIterator = new BookIterator($bookData);
            $books->push($bookIterator);
        }

        return $books;
    }

    public function getBookById($id): BookIterator
    {
        $book = $this->booksRepository->getBookById($id);
        return new BookIterator($book);
    }

    public function store(BookStoreDTO $bookDTO): BookIterator
    {
        $bookId = $this->booksRepository->store($bookDTO);

        $book = $this->booksRepository->getBookById($bookId);

        return new BookIterator($book);

    }


    public function updateBook($bookUpdateDTO): BookIterator
    {
        $isUpdated = $this->booksRepository->updateBook($bookUpdateDTO);
        if ($isUpdated == null) {
            throw new Exception('Failed to update book.');
        }
        $book = $this->booksRepository->getBookById($bookUpdateDTO->getId());
        return new BookIterator($book);
    }

    public function deleteBook($id): bool
    {
        return $this->booksRepository->deleteBook($id);
    }
}
