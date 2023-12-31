<?php

namespace App\Http\Controllers;

use App\Enum\LangEnum;
use App\Enum\LimitEnum;
use App\Services\BooksService;
use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookIndexRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Repositories\Books\DTO\BookIndexDTO;
use App\Repositories\Books\DTO\BookStoreDTO;
use App\Repositories\Books\DTO\BookUpdateDTO;

use Carbon\Carbon;


class BooksController extends Controller
{
    public function __construct(
        protected BooksService $booksService
    ) {
    }


    public function chunkTest()
    {
        $this->booksService->chunkTest();
        return response("chunkTestUpdateBookNames done", 200);
    }

    /* INDEX DONE */
    public function index(BookIndexRequest $request)
    {

        $validatedData = $request->validated();

        $bookIndexDTO = new BookIndexDTO(
            new Carbon($validatedData['startDate']),
            new Carbon($validatedData['endDate']),
            $validatedData['year'] ?? null,
            LangEnum::tryFrom($validatedData['lang'] ?? null),// Довго розбирався, запрацювало...
            $validatedData['lastId'] ?? 0,
            LimitEnum::tryFrom($validatedData['limit'] ?? LimitEnum::LIMIT_20->value),
        );


        $books = $this->booksService->getBooksForIndex($bookIndexDTO);

        $resource = BookResource::collection($books);

        $metaLastId = $books->isNotEmpty() ? $books->last()->getId() : 0; // Тернарочка )
        return response()->json(
            [
                'data' => $resource,
                'meta' => [
                    'startId' => $bookIndexDTO->getStartId(),
                    'lastId' => $metaLastId,
                    'limit' => $bookIndexDTO->getLimit()->value,
                    'totalCount' => $books->count(),
                ],
            ], 200
        );
    }

    /* STORE DONE */
    public function store(BookStoreRequest $request)
    {
        $validatedData = $request->validated();

        $bookDTO = new BookStoreDTO(
            $validatedData['name'],
            $validatedData['year'],
            LangEnum::from($validatedData['lang']),
            $validatedData['pages'],
            $validatedData['categoryId'],
            Carbon::now(),
            Carbon::now(),
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

    /* UPDATE DONE */

    public function update(BookUpdateRequest $request)
    {
        $validatedData = $request->validated();
        $bookIterator = $this->booksService->getBookById($validatedData['id']);


        $bookUpdateDTO = new BookUpdateDTO(
            $validatedData['id'],
            $validatedData['name'],
            $validatedData['year'],
            LangEnum::from($validatedData['lang']),
            $validatedData['pages'],
            $validatedData['categoryId'],
            $bookIterator->getCreatedAt(),
            now(),
        );

        $bookIterator = $this->booksService->updateBook($bookUpdateDTO);

        return response(new BookResource($bookIterator), 200);
    }

    public function destroy(BookDestroyRequest $request)
    {
        $validatedData = $request->validated();
        if ($this->booksService->deleteBook($validatedData['id'])) {
            return response()->json(['message' => 'Book id - ' . $validatedData['id'] . ' deleted successfully']);
        }
        return response()->json(['message' => 'Book id - ' . $validatedData['id'] . ' delete failure or no content.'], 422); //422 - Unprocessable Entity

    }


}
