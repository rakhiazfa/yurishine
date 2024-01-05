<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $column = $request->query('column');
        $keyword = $request->query('keyword');

        $query = Patient::latest();

        if (!$column) {
            $query->where('registrasion_number', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('age', 'LIKE', "%{$keyword}%")
                ->orWhere('gender', 'LIKE', "%{$keyword}%")
                ->orWhere('skin_type', 'LIKE', "%{$keyword}%")
                ->orWhere('address', 'LIKE', "%{$keyword}%")
                ->orWhere('phone', 'LIKE', "%{$keyword}%");
        } else {
            $query->where($column, 'LIKE', "%{$keyword}%");
        }

        $patients = $query->get();

        return Inertia::render('patients/Index', [
            'patients' => $patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('patients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePatientRequest $request)
    {
        Patient::create($request->all());

        return to_route('patients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return Inertia::render('patients/Show', [
            'patient' => $patient,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return Inertia::render('patients/Edit', [
            'patient' => $patient,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $name = $request->input('name');
        $age = $request->input('age');
        $gender = $request->input('gender');
        $skinType = $request->input('skin_type');
        $address = $request->input('address');
        $phone = $request->input('phone');

        $patient->name = $name;
        $patient->age = $age;
        $patient->gender = $gender;
        $patient->skin_type = $skinType;
        $patient->address = $address;
        $patient->phone = $phone;

        $patient->save();

        return to_route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return to_route('patients.index');
    }
}
