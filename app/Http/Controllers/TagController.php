<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TagResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class TagController extends Controller
{
    /**
     * Initial related repository for this controller
     */
    public function __construct(
        public \App\Repositories\Tag\TagRepository $mainRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return TagResource::collection(
            $this->mainRepository->paginate()
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request): JsonResponse
    {
        $tag = $this->mainRepository->create([
            'name' => $request->string('name')
        ]);

        return response()->json([
            'message' => __('model_name.created'),
            'data' => new TagResource($tag),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResource
    {
        return new TagResource(
            $this->mainRepository->FindOrFail($id)
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, int $id): JsonResponse
    {
        $this->mainRepository->update($id, [
            'name' => $request->string('name')
        ]);

        return response()->json([
            'message' => __('actions.updated', ['attribute' => 'Tag']),
            'data' => new TagResource(
                $this->mainRepository->FindOrFail($id)
            ),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->mainRepository->delete($id))
            return response()->json([
                'message' => __('actions.deleted', ['attribute' => 'Tag'])
            ]);
        
        return response()->json(__('unprocessable_entity'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
