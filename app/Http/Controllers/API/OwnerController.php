<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerStoreRequest;
use App\Http\Requests\OwnerUpdateRequest;
use App\Http\Resources\OwnerCollection;
use App\Http\Resources\OwnerResource;
use App\Models\Owner;

class OwnerController extends Controller
{

    /**
     * @return OwnerCollection
     */
    public function index()
    {
        return new OwnerCollection(Owner::paginate());
    }

    /**
     * @param OwnerStoreRequest $request
     * @return OwnerResource
     */
    public function store(OwnerStoreRequest $request)
    {
        return new OwnerResource(Owner::create($request->validated()));
    }

    /**
     * @param Owner $owner
     * @return OwnerResource
     */
    public function show(Owner $owner)
    {
        return new OwnerResource($owner);
    }

    /**
     * @param OwnerUpdateRequest $request
     * @param Owner $owner
     * @return OwnerResource
     */
    public function update(OwnerUpdateRequest $request, Owner $owner)
    {
        $owner->update($request->validated());

        return new OwnerResource($owner);
    }

    /**
     * @param Owner $owner
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Owner $owner)
    {
        try {
            $owner->delete();
            return response()->json([], 204);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
