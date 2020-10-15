<?php

namespace App\Http\Controllers;

use App\Actions\Estates\CreateNewEstate;
use App\Actions\Estates\DeleteEstate;
use App\Http\Requests\EstateCSVRequest;
use App\Http\Requests\EstateStoreRequest;
use App\Jobs\ImportEstatesFromCSV;
use App\Models\Estate;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EstateController extends Controller
{

    public function index()
    {
        return Inertia::render('Estates/Index', [
            'estates' => Estate::with('owner')->get(),
        ]);
    }

    public function store(EstateStoreRequest $request, CreateNewEstate $creator)
    {
        $creator->create($request->validated());
        return back()->with('flash', 'Created successfully.');
    }

    public function destroy(Estate $estate, DeleteEstate $destroyer)
    {
        try {
            $destroyer->delete($estate);
            return back();
        } catch (\Exception $exception) {
            return back()->with([
                'error' => 'This estate cannot be removed. Please contact the support.'
            ]);
        }
    }

    public function csv(EstateCSVRequest $request)
    {
        $path = $request->csv->storeAs('imports', Str::random(10) . '.csv');

        ImportEstatesFromCSV::dispatch($path);

        return back()->with('flash', 'Import registered.');
    }
}
