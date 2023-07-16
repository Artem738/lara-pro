<?php

namespace App\Repositories\Categories;

use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\DTO\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Categories\DTO\CategoryStoreDTO;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoriesRepository
{
    public function getAllCategories(): Collection // of iterators
    {
        $categoriesData = DB::table('categories')->get();

        $categories = collect();

        foreach ($categoriesData as $categoryData) {
            $categoryIterator = new CategoryIterator($categoryData);
            $categories->push($categoryIterator);
        }

        return $categories;
    }

    public function store(CategoryStoreDTO $catStoreDTO): int
    {
        $catId = DB::table('categories')->insertGetId(
            [
                'name' => $catStoreDTO->getName(),
                'created_at' => $catStoreDTO->getCreatedAt(),
                'updated_at' => $catStoreDTO->getUpdatedAt(),
            ]
        );

        return $catId;
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
        $deleted = DB::table('categories')->delete($id);
        return $deleted > 0;
    }

    public function getCategoryById(int $id): CategoryIterator
    {
        $catData = DB::table('categories')
            ->where('id', '=', $id)
            ->select(
                [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ]
            )
            ->get()
            ->first();
        return new CategoryIterator($catData);
    }

}
