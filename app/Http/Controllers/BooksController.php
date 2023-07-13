<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Requests\Book\BookIndexRequest;
use App\Http\Resources\BookResource;
use App\Services\BooksService;
use App\DTO\BookDTO;
use Symfony\Component\HttpFoundation\Response;


class BooksController extends Controller
{
    public function __construct(
        protected BooksService $booksService
    ) {

    }


    public function index(BookIndexRequest $request)
    {
        $validatedData = $request->validated();

        $books = $this->booksService->getBooksForIndex(
            $validatedData['startDate'],
            $validatedData['endDate'],
            $validatedData['year'] ?? null,
            $validatedData['lang'] ?? null,
        );

        return BookResource::collection($books);
    }

    /* STORE DONE */
    public function store(BookStoreRequest $request)
    {
        $validatedData = $request->validated();

        $bookDTO = new BookDTO(
            $validatedData['name'],
            $validatedData['year'],
            $validatedData['lang'],
            $validatedData['pages'],
            now(),
            now(),
        );

        $bookIterator = $this->booksService->store($bookDTO);
        $bookResource = new BookResource($bookIterator);
        return response($bookResource, 201);  //201 - request was successful and as a result, a resource has been created.
    }

    /* SHOW DONE */
    public function show(BookShowRequest $request)
    {
        $validatedData = $request->validated();
        $bookIterator = $this->booksService->getBookById($validatedData['id']);
        $bookResource = new BookResource($bookIterator);
        return response($bookResource, 200);
    }

    /* UPDATE UNDER CONSTRUCTION !!!! */
    public function update(BookUpdateRequest $request)
    {
        $validatedData = $request->validated();
        $bookIterator = $this->booksService->getBookById($validatedData['id']);


        $bookDTO = new BookDTO(
            $validatedData['name'],
            $validatedData['year'],
            $validatedData['lang'],
            $validatedData['pages'],
            $bookIterator->getCreatedAt(),
            now(),
        );

        $bookIterator = $this->booksService->updateBook($validatedData['id'], $bookDTO);

        return response(new BookResource($bookIterator), 200);
    }

    public function destroy(BookDestroyRequest $request)
    {
        $validatedData = $request->validated();
        $this->booksService->deleteBook($validatedData['id']);

        return response()->json(['message' => 'Book id - ' . $validatedData['id'] . ' deleted successfully']);
    }
}
