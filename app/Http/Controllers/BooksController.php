<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
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
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $year = $request->input('year');
        $lang = $request->input('lang');

        $books = $this->booksService->getBooks($startDate, $endDate, $year, $lang);

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
    public function update(BookUpdateRequest $request): BookResource
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

        $book = $this->booksService->updateBook($validatedData['id'], $bookDTO);

        return response( new BookResource($book), 200);
    }

    public function destroy(BookDestroyRequest $request, int $id)
    {
        $this->booksService->deleteBook($id);

        return response()->json(['message' => 'Book id - ' . $id . ' deleted successfully']);
    }
}
