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
        return  $this->booksRepository->getBooksBetweenCreatedAtAndWhereLangAndYear($bookIndexDTO);
    }

    public function getBookById($id): BookIterator
    {
        return  $this->booksRepository->getBookById($id);
    }

    public function store(BookStoreDTO $bookDTO): BookIterator
    {
        $bookId = $this->booksRepository->store($bookDTO);

        return $this->booksRepository->getBookById($bookId);
    }

    public function updateBook($bookUpdateDTO): BookIterator
    {
        $isUpdated = $this->booksRepository->updateBook($bookUpdateDTO);
        if ($isUpdated == null) {
            throw new Exception('Failed to update book.');
        }
        return $this->booksRepository->getBookById($bookUpdateDTO->getId());
    }

    public function deleteBook($id): bool
    {
        return $this->booksRepository->deleteBook($id);
    }
}
