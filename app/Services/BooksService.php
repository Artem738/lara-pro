<?php

namespace App\Services;

use App\DTO\BookDTO;
use App\Repositories\Books\BooksRepository;
use App\Repositories\Books\Iterators\BookIterator;

class BooksService
{
    public function __construct(
        protected BooksRepository $booksRepository
    ) {
    }

    public function getBooks($bookDTO)
    {
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


    public function updateBook($id, BookDTO $bookDTO)
    {
        return $this->booksRepository->updateBook($id, $bookDTO);
    }

    public function deleteBook($id)
    {
        $this->booksRepository->deleteBook($id);
    }
}
