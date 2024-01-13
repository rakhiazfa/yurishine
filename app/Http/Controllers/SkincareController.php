<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSkincareRequest;
use App\Http\Requests\UpdateSkincareRequest;
use App\Models\Skincare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class SkincareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $column = $request->query('column');
        $keyword = $request->query('keyword');

        $query = Skincare::latest();

        if (!$column) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhere('price', 'LIKE', "%{$keyword}%");
        } else {
            $query->where($column, 'LIKE', "%{$keyword}%");
        }

        $skincares = $query->paginate(10)->withQueryString();

        return Inertia::render('skincares/Index', [
            'skincares' => $skincares,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('skincares/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSkincareRequest $request)
    {
        Cache::forget('skincare_options');

        Skincare::create($request->all());

        Cache::remember('skincare_options', 12 * 60 * 60, function () {
            return Skincare::latest()->get();
        });

        return to_route('skincares.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skincare $skincare)
    {
        return Inertia::render('skincares/Show', [
            'skincare' => $skincare,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skincare $skincare)
    {
        return Inertia::render('skincares/Edit', [
            'skincare' => $skincare,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkincareRequest $request, Skincare $skincare)
    {
        Cache::forget('skincare_options');

        $skincare->update($request->all());

        Cache::remember('skincare_options', 12 * 60 * 60, function () {
            return Skincare::latest()->get();
        });

        return to_route('skincares.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skincare $skincare)
    {
        Cache::forget('skincare_options');

        $skincare->delete();

        Cache::remember('skincare_options', 12 * 60 * 60, function () {
            return Skincare::latest()->get();
        });

        return to_route('skincares.index');
    }
}
