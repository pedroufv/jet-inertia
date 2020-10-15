<?php

namespace App\Http\Controllers;

use App\Actions\Owners\CreateNewOwner;
use App\Actions\Owners\DeleteOwner;
use App\Http\Requests\OwnerStoreRequest;
use App\Models\Estate;
use App\Models\Owner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
    public function index()
    {
        return Inertia::render('Owners/Index', [
            'owners' => Owner::with('estates')->get(),
            'unowned' => Estate::whereNull('owner_id')->get(),
        ]);
    }

    /**
     * Update the given API token's permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Owner  $owner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Owner $owner)
    {
        $owner->estates()->update(['owner_id' => null]);

        $estateIds = array_map(fn ($item) => $item['id'], $request->estates);

        Estate::whereIn('id', $estateIds)->update(['owner_id' => $owner->id]);

        return back();
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
                'flash' => 'This owner cannot be removed. Please check if there are any properties associated with it.'
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function selectInput()
    {
        return Owner::all(['id', 'email']);
    }
}
