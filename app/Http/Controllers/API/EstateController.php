<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstateStoreRequest;
use App\Http\Requests\EstateUpdateRequest;
use App\Http\Resources\EstateCollection;
use App\Http\Resources\EstateResource;
use App\Models\Estate;

class EstateController extends Controller
{

    /**
     * @return EstateCollection
     */
    public function index()
    {
        return new EstateCollection(Estate::paginate());
    }

    /**
     * @param EstateStoreRequest $request
     * @return EstateResource
     */
    public function store(EstateStoreRequest $request)
    {
        return new EstateResource(Estate::create($request->validated()));
    }

    /**
     * @param Estate $estate
     * @return EstateResource
     */
    public function show(Estate $estate)
    {
        return new EstateResource($estate);
    }

    /**
     * @param EstateUpdateRequest $request
     * @param Estate $estate
     * @return EstateResource
     */
    public function update(EstateUpdateRequest $request, Estate $estate)
    {
        $estate->update($request->validated());

        return new EstateResource($estate);
    }

    /**
     * @param Estate $estate
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Estate $estate)
    {
        try {
            $estate->delete();
            return response()->json([], 204);
        } catch (\Exception $exception) {
            return response()->json(new EstateResource($estate), 500);
        }
    }
}
