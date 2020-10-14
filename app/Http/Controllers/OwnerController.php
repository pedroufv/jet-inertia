<?php

namespace App\Http\Controllers;

use App\Actions\Owners\CreateNewOwner;
use App\Actions\Owners\DeleteOwner;
use App\Http\Requests\OwnerStoreRequest;
use App\Models\Owner;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function index()
    {
        return Inertia::render('Owners/Index', [
            'owners' => Owner::withCount('estates')->get(),
        ]);
    }

    public function store(OwnerStoreRequest $request, CreateNewOwner $creator)
    {
        $creator->create($request->validated());
        return back()->with('flash', 'Created successfully.');
    }

    public function destroy(Owner $owner, DeleteOwner $destroyer)
    {
        try {
            $destroyer->delete($owner);
            return back();
        } catch (\Exception $exception) {
            return back()->with([
                'error' => 'This owner cannot be removed. Please check if there are any properties associated with it.'
            ]);
        }
    }
}
