<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Builder;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    /**
     * Initaial related repository for this controller
     */
    public function __construct(
        public \App\Repositories\Author\AuthorRepository $mainRepository,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if($request->filled('tag'))
            $authors = $this->mainRepository->paginateHasTag($request->integer('tag'));
        else
            $authors = $this->mainRepository->paginate();

        return AuthorResource::collection($authors);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {

        $author = $this->mainRepository->create([
            'name' => $request->string('name')
        ]);

        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return new AuthorResource($this->mainRepository->FindOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, int $id)
    {
        $this->mainRepository->update($id, [
            'name' => $request->string('name')
        ]);

        return new AuthorResource($this->mainRepository->FindOrFail($id));
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

    // TODO: 1.repository Design pattern 2.test 4.api Resourse 3.git

}
