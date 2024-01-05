<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePolyclinicRequest;
use App\Http\Requests\UpdatePolyclinicRequest;
use App\Models\Polyclinic;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PolyclinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $column = $request->query('column');
        $keyword = $request->query('keyword');

        $query = Polyclinic::with('user')->latest();

        if (!$column) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('address', 'LIKE', "%{$keyword}%")
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('email', 'LIKE', "%{$keyword}%");
                });
        } else if ($column === 'email') {
            $query->whereHas('user', function ($query) use ($keyword) {
                $query->where('email', 'LIKE', "%{$keyword}%");
            });
        } else {
            $query->where($column, 'LIKE', "%{$keyword}%");
        }

        $polyclinics = $query->get();

        return Inertia::render('polyclinics/Index', [
            'polyclinics' => $polyclinics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('polyclinics/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePolyclinicRequest $request)
    {
        $user = User::create($request->all());
        $polyclinic = new Polyclinic($request->all());

        $polyclinic->user()->associate($user);
        $polyclinic->save();

        return to_route('polyclinics.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Polyclinic $polyclinic)
    {
        $polyclinic->load('user');

        return Inertia::render('polyclinics/Show', [
            'polyclinic' => $polyclinic,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Polyclinic $polyclinic)
    {
        $polyclinic->load('user');

        return Inertia::render('polyclinics/Edit', [
            'polyclinic' => $polyclinic,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePolyclinicRequest $request, Polyclinic $polyclinic)
    {
        $name = $request->input('name');
        $address = $request->input('address');
        $email = $request->input('email');
        $password = $request->input('password');

        $polyclinic->name = $name;
        $polyclinic->address = $address;
        $polyclinic->user->name = $name;
        $polyclinic->user->email = $email;

        if ($password) {
            $polyclinic->user->password = $password;
        }

        $polyclinic->push();

        return to_route('polyclinics.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Polyclinic $polyclinic)
    {
        $polyclinic->user->delete();
        $polyclinic->delete();

        return to_route('polyclinics.index');
    }
}
