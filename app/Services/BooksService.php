<?php

namespace App\Services;

use App\DTO\BookDTO;
use App\Repositories\Books\BooksRepository;
use App\Repositories\Books\Iterators\BookIterator;
use Exception;


class BooksService
{
    public function __construct(
        protected BooksRepository $booksRepository
    ) {
    }

    public function getBooksForIndex($startDate, $endDate, $year = null, $lang = null): \Illuminate\Support\Collection //РОЗІБРАТИСЯ ТРЕБА ТАК ЧИ НІ!!!!
    {
        $booksData = $this->booksRepository->getBooks($startDate, $endDate, $year, $lang);

        $books = collect();

        foreach ($booksData as $bookData) {
            $bookIterator = new BookIterator($bookData);
            $books->push($bookIterator);
        }

        return $books;
    }

    public function getBookById($id): BookIterator
    {
        $bookIterator = $this->booksRepository->getBookById($id);
        return new BookIterator($bookIterator);
    }

    public function store(BookDTO $bookDTO): BookIterator
    {
        $bookId = $this->booksRepository->store($bookDTO);

        $bookIterator = $this->booksRepository->getBookById($bookId);
        // $bookResource = new BookResource($book);
        return new BookIterator($bookIterator);

    }


    public function updateBook($id, $bookDTO): BookIterator
    {
        $isUpdated = $this->booksRepository->updateBook($id, $bookDTO);
        if ($isUpdated == null) { //ругається на ===
            throw new Exception('Failed to update book.');
        }
        $bookIterator = $this->booksRepository->getBookById($id);
        return new BookIterator($bookIterator);
    }

    public function deleteBook($id): bool
    {
        return $this->booksRepository->deleteBook($id);
    }
}
