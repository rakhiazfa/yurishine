<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $column = $request->query('column');
        $keyword = $request->query('keyword');

        $query = Treatment::latest();

        if (!$column) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhere('price', 'LIKE', "%{$keyword}%");
        } else {
            $query->where($column, 'LIKE', "%{$keyword}%");
        }

        $treatments = $query->get();

        return Inertia::render('treatments/Index', [
            'treatments' => $treatments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('treatments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTreatmentRequest $request)
    {
        Cache::forget('treatment_options');

        Treatment::create($request->all());

        return to_route('treatments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        return Inertia::render('treatments/Show', [
            'treatment' => $treatment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        return Inertia::render('treatments/Edit', [
            'treatment' => $treatment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatmentRequest $request, Treatment $treatment)
    {
        Cache::forget('treatment_options');

        $treatment->update($request->all());

        return to_route('treatments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        Cache::forget('treatment_options');

        $treatment->delete();

        return to_route('treatments.index');
    }
}
