<?php

//namespace App\DTO;
namespace App\Services;


use App\Repositories\Books\BooksRepository;
use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Exception;


class BooksService
{
    public function __construct(
        protected BooksRepository $booksRepository
    ) {
    }

    public function getBooksForIndex(BookIndexDTO $bookIndexDTO) ///: \Illuminate\Support\Collection //РОЗІБРАТИСЯ ТРЕБА ТАК ЧИ НІ!!!!
    {
        $booksData = $this->booksRepository->getBooks($bookIndexDTO);

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

    public function store(BookStoreDTO $bookDTO): BookIterator
    {
        $bookId = $this->booksRepository->store($bookDTO);

        $bookIterator = $this->booksRepository->getBookById($bookId);
        // $bookResource = new BookResource($book);
        return new BookIterator($bookIterator);

    }


    public function updateBook($bookUpdateDTO): BookIterator
    {
        $isUpdated = $this->booksRepository->updateBook($bookUpdateDTO);
        if ($isUpdated == null) {
            throw new Exception('Failed to update book.');
        }
        $bookIterator = $this->booksRepository->getBookById($bookUpdateDTO->getId());
        return new BookIterator($bookIterator);
    }

    public function deleteBook($id): bool
    {
        return $this->booksRepository->deleteBook($id);
    }
}
