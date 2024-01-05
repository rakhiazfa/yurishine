<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $column = $request->query('column');
        $keyword = $request->query('keyword');

        $query = Doctor::with('user')->latest();

        if (!$column) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('specialist', 'LIKE', "%{$keyword}%")
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

        $doctors = $query->get();

        return Inertia::render('doctors/Index', [
            'doctors' => $doctors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('doctors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDoctorRequest $request)
    {
        Cache::forget('doctor_options');

        $user = User::create($request->all());
        $doctor = new Doctor($request->all());

        $doctor->user()->associate($user);
        $doctor->save();

        return to_route('doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load('user');

        return Inertia::render('doctors/Show', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $doctor->load('user');

        return Inertia::render('doctors/Edit', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        Cache::forget('doctor_options');

        $name = $request->input('name');
        $specialist = $request->input('specialist');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $password = $request->input('password');

        $doctor->name = $name;
        $doctor->specialist = $specialist;
        $doctor->address = $address;
        $doctor->phone = $phone;
        $doctor->user->name = $name;
        $doctor->user->email = $email;

        if ($password) {
            $doctor->user->password = $password;
        }

        $doctor->push();

        return to_route('doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        Cache::forget('doctor_options');

        $doctor->user->delete();
        $doctor->delete();

        return to_route('doctors.index');
    }
}
