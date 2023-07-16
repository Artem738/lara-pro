<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCheckIdRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\Categories\DTO\CategoryStoreDTO;
use App\Services\BooksService;
use App\Services\CategoriesService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct(
        protected CategoriesService $categoriesService
    ) {
    }

    /**
     * Index DONE
     */
    public function index()
    {
        $data = $this->categoriesService->getAllCategories();
        return response(CategoryResource::collection($data), 200);
    }

    /**
     *
     */
    public function store(CategoryStoreRequest $request)
    {
        $valid = $request->validated();
        echo ($valid['name']);
        $catDTO = new CategoryStoreDTO(
            $valid['name'],
            Carbon::now(),
            Carbon::now(),
        );

        $catIterator = $this->categoriesService->store($catDTO);
        $catResource = new CategoryResource($catIterator);
        return response($catResource, 201);  //201 - request was successful and as a result, a resource has been created.
    }

    /**
     *
     */
    public function show(CategoryCheckIdRequest $request)
    {
        $valid = $request->validated();
        $catIterator = $this->categoriesService->getCategoryById($valid['id']);
        $catResource = new CategoryResource($catIterator);
        return response($catResource, 200);
    }

    /**
     *
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     *
     */
    public function destroy(string $id)
    {
        //
    }
}
