<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;

use App\Http\Resources\BookResource;


class BookController extends Controller
{
    private array $bookObjectsDemoArray;

    public function __construct()
    {
        $this->bookObjectsDemoArray = [
            (object)[
                'id' => 1,
                'name' => 'Book 1',
                'author' => 'Author 1',
                'year' => 2021,
                'countPages' => 100,
            ],
            (object)[
                'id' => 2,
                'name' => 'Book 2',
                'author' => 'Author 2',
                'year' => 2022,
                'countPages' => 250,
            ],
            (object)[
                'id' => 3,
                'name' => 'Book 3',
                'author' => 'Author 3',
                'year' => 2003,
                'countPages' => 300,
            ],
        ];
    }

    public function index()
    {
        return BookResource::collection($this->bookObjectsDemoArray);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request)
    {
        $validatedData = $request->validated();

        $tempBookObject = (object)[
            'id' => 42,
            'name' => $validatedData['name'],
            'author' => $validatedData['author'],
            'year' => $validatedData['year'],
            'countPages' => $validatedData['countPages'],
        ];

        return new BookResource($tempBookObject);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookShowRequest $request, string $id)
    {
        $book = collect($this->bookObjectsDemoArray)->firstWhere('id', $id);

        if ($book) {
            return new BookResource($book);
        }
        return response()->json(['error' => 'Book not found'], 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $updatedBook = (object)[
            'id' => $request['id'],
            'name' => $validatedData['name'],
            'author' => $validatedData['author'],
            'year' => $validatedData['year'],
            'countPages' => $validatedData['countPages'],
        ];

        return new BookResource($updatedBook);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookDestroyRequest $request, string $id)
    {
        //$request->validated();
        //  curl -X DELETE http://lara-pro.loc/api/books/123    BookUpdateRequest
        echo "destroy " . $id . PHP_EOL;

    }
}
