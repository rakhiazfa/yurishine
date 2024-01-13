<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

        $patients = $query->paginate(10)->withQueryString();

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
        Cache::forget('patient_options');
        Cache::forget('patient_doesnt_have_options');

        Patient::create($request->all());

        Cache::remember('patient_options', 12 * 60 * 60, function () {
            return Patient::latest()->get();
        });
        Cache::remember('patient_doesnt_have_options', 12 * 60 * 60, function () {
            return Patient::doesntHave('membership')->latest()->get();
        });

        return to_route('patients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $medicalRecords = $patient->medicalRecords()->with(['doctor', 'treatments'])->paginate(15);

        return Inertia::render('patients/Show', [
            'patient' => $patient,
            'medicalRecords' => $medicalRecords,
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
        Cache::forget('patient_options');
        Cache::forget('patient_doesnt_have_options');

        $name = $request->input('name');
        $age = $request->input('age');
        $gender = $request->input('gender');
        $skinType = $request->input('skin_type');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $isSmoked = $request->input('is_smoked');
        $usingKB = $request->input('using_kb');
        $usingSkincare = $request->input('using_skincare');
        $alreadyUseMixedCream = $request->input('already_use_mixed_cream');

        $patient->name = $name;
        $patient->age = $age;
        $patient->gender = $gender;
        $patient->skin_type = $skinType;
        $patient->address = $address;
        $patient->phone = $phone;
        $patient->is_smoked = $isSmoked;
        $patient->using_kb = $usingKB;
        $patient->using_skincare = $usingSkincare;
        $patient->already_use_mixed_cream = $alreadyUseMixedCream;

        $patient->save();

        Cache::remember('patient_options', 12 * 60 * 60, function () {
            return Patient::latest()->get();
        });
        Cache::remember('patient_doesnt_have_options', 12 * 60 * 60, function () {
            return Patient::doesntHave('membership')->latest()->get();
        });

        return to_route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        Cache::forget('patient_options');
        Cache::forget('patient_doesnt_have_options');

        $patient->delete();

        Cache::remember('patient_options', 12 * 60 * 60, function () {
            return Patient::latest()->get();
        });
        Cache::remember('patient_doesnt_have_options', 12 * 60 * 60, function () {
            return Patient::doesntHave('membership')->latest()->get();
        });

        return to_route('patients.index');
    }
}
