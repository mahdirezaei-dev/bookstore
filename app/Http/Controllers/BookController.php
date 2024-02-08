<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{

    /**
     * Initaial related repository for this controller
     */
    public function __construct(
        public \App\Repositories\Book\BookRepository $mainRepository,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->filled('tag'))
            $books = $this->mainRepository->paginateHasTag($request->integer('tag'));
        else
            $books = $this->mainRepository->paginate();

        return BookResource::collection($books);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $book = $this->mainRepository->create([
            'title' => $request->string('title'),
            'price' => $request->string('price'),
            'author_id' => $request->string('author_id'),
        ]);

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return new BookResource($this->mainRepository->FindOrFail($id));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, int $id)
    {

        $this->mainRepository->update($id, [
            'title' => $request->string('title'),
            'price' => $request->string('price'),
            'author_id' => $request->string('author_id'),
        ]);

        return new BookResource($this->mainRepository->FindOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if ($this->mainRepository->delete($id)) {
            return response()->json(['message' => __('deleted')]);
        }

        return response()->json(__('unprocessable_entity'), Response::HTTP_UNPROCESSABLE_ENTITY);

    }
}
