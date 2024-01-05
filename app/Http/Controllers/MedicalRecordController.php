<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Report;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');

        $query = MedicalRecord::with(['patient', 'doctor', 'polyclinic'])->latest();

        if ($keyword) {
            $query->whereHas('patient', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
                ->orWhereHas('doctor', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
        }

        $medicalRecords = $query->get();

        return Inertia::render('medical-records/Index', [
            'medicalRecords' => $medicalRecords,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::latest()->get();
        $doctors = Doctor::latest()->get();
        $medicines = Medicine::latest()->get();
        $treatments = Treatment::latest()->get();

        return Inertia::render('medical-records/Create', [
            'patients' => $patients,
            'doctors' => $doctors,
            'medicines' => $medicines,
            'treatments' => $treatments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMedicalRecordRequest $request)
    {
        $medicines = $request->input('medicines', []);
        $treatments = $request->input('treatments', []);

        $medicalRecord = MedicalRecord::create($request->all());
        $medicalRecord->medicines()->sync($medicines);
        $medicalRecord->treatments()->sync($treatments);

        Report::create([
            'patient_name' => $medicalRecord->patient->name,
            'patient_address' => $medicalRecord->patient->address,
            'patient_phone' => $medicalRecord->patient->phone,
            'doctor_name' => $medicalRecord->doctor->name,
            'polyclinic_name' => $medicalRecord->polyclinic?->name ?? null,
            'description' => $medicalRecord->description,
            'treatments' => $medicalRecord->treatments,
            'inspection_date' => $medicalRecord->created_at,
        ]);

        return to_route('medical-records.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'polyclinic', 'medicines', 'treatments']);

        return Inertia::render('medical-records/Show', [
            'medicalRecord' => $medicalRecord,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'polyclinic', 'medicines', 'treatments']);

        $patients = Patient::latest()->get();
        $doctors = Doctor::latest()->get();
        $medicines = Medicine::latest()->get();
        $treatments = Treatment::latest()->get();

        return Inertia::render('medical-records/Edit', [
            'medicalRecord' => $medicalRecord,
            'patients' => $patients,
            'doctors' => $doctors,
            'medicines' => $medicines,
            'treatments' => $treatments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $medicines = $request->input('medicines', []);
        $treatments = $request->input('treatments', []);

        $medicalRecord->update($request->all());
        $medicalRecord->medicines()->sync($medicines);
        $medicalRecord->treatments()->sync($treatments);

        return to_route('medical-records.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return to_route('medical-records.index');
    }
}
