<?php
//namespace App\DTO;
namespace App\Services;

use App\Repositories\Books\BooksRepository;
use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Categories\DTO\CategoryStoreDTO;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Exception;
use Illuminate\Support\Collection;

class CategoriesService
{
    public function __construct(
        protected CategoriesRepository $categoriesRepository
    ) {
    }

    public function getAllCategories(): Collection
    {
        return  $this->categoriesRepository->getAllCategories();
    }
    public function store(CategoryStoreDTO $catDTO): CategoryIterator
    {
        $catId = $this->categoriesRepository->store($catDTO);

        return $this->categoriesRepository->getCategoryById($catId);
    }

    public function getCategoryById($id): CategoryIterator
    {
        return  $this->categoriesRepository->getCategoryById($id);
    }

    public function updateCategory($categoryUpdateDTO): CategoryIterator
    {
        $isUpdated = $this->categoriesRepository->updateCategory($categoryUpdateDTO);
        if ($isUpdated == null) {
            throw new Exception('Failed to update category.');
        }
        return $this->categoriesRepository->getCategoryById($categoryUpdateDTO->getId());
    }

    public function deleteCategory($id): bool
    {
        return $this->categoriesRepository->deleteBook($id);
    }
}
