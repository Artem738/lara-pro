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

        return response($bookResource, Response::HTTP_CREATED);
    }


    public function show(BookShowRequest $request, int $id)
    {
        $book = $this->booksService->getBookById($id);

        if ($book) {
            return new BookResource($book);
        }

        return response()->json(['error' => 'Book not found'], 404);
    }


    public function update(BookUpdateRequest $request, int $id)
    {
        $validatedData = $request->validated();

        $bookDTO = new BookDTO(
            $validatedData['name'],
            $validatedData['year'],
            $validatedData['lang'],
            $validatedData['pages']
        );

        $book = $this->booksService->updateBook($id, $bookDTO);

        return new BookResource($book);
    }

    public function destroy(BookDestroyRequest $request, int $id)
    {
        $this->booksService->deleteBook($id);

        return response()->json(['message' => 'Book id - ' . $id . ' deleted successfully']);
    }
}
