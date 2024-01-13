<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Report;
use App\Models\Skincare;
use App\Models\Treatment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('registrasion_number', 'LIKE', "%{$keyword}%");
            })
                ->orWhereHas('doctor', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
        }

        $medicalRecords = $query->paginate(10)->withQueryString();

        return Inertia::render('medical-records/Index', [
            'medicalRecords' => $medicalRecords,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Cache::remember('patient_options', 12 * 60 * 60, function () {
            return Patient::withCount('membership')->latest()->get();
        });
        $doctors = Cache::remember('doctor_options', 12 * 60 * 60, function () {
            return Doctor::latest()->get();
        });
        $treatments = Cache::remember('treatment_options', 2 * 60, function () {
            return Treatment::latest()->get();
        });
        $skincares = Cache::remember('skincare_options', 2 * 60, function () {
            return Skincare::latest()->get();
        });

        return Inertia::render('medical-records/Create', [
            'patients' => $patients,
            'doctors' => $doctors,
            'treatments' => $treatments,
            'skincares' => $skincares,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMedicalRecordRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $treatments = $request->input('treatments', []);
                $skincares = $request->input('skincares', []);

                $selectedSkincares = DB::table('skincares')->whereIn('id', $skincares)->get();

                foreach ($selectedSkincares as $skincare) {
                    if ($skincare->stock > 0) {
                        DB::table('skincares')->where('id', $skincare->id)->decrement('stock');
                    } else {
                        throw new BadRequestHttpException('Stock telah kosong untuk produk dengan nama ' . $skincare->name);
                    }
                }

                $medicalRecord = MedicalRecord::create($request->all());
                $medicalRecord->treatments()->sync($treatments);
                $medicalRecord->skincares()->sync($skincares);

                Report::create([
                    'patient_id' => $medicalRecord->patient->id,
                    'patient_registrasion_number' => $medicalRecord->patient->registrasion_number,
                    'patient_name' => $medicalRecord->patient->name,
                    'patient_address' => $medicalRecord->patient->address,
                    'patient_phone' => $medicalRecord->patient->phone,
                    'doctor_id' => $medicalRecord->doctor->id,
                    'doctor_name' => $medicalRecord->doctor->name,
                    'polyclinic_name' => $medicalRecord->polyclinic?->name ?? null,
                    'description' => $medicalRecord->description,
                    'treatments' => $medicalRecord->treatments,
                    'skincares' => $medicalRecord->skincares,
                    'inspection_date' => $medicalRecord->created_at,
                    'use_membership' => $medicalRecord->use_membership,
                ]);
            });

            return to_route('medical-records.index');
        } catch (Exception $exception) {
            return back()->withErrors([
                'error' => $exception->getMessage() ?? 'Gagal menyimpan rekam medis.',
                'statusCode' => 502,
            ])->onlyInput('error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'polyclinic', 'treatments', 'skincares']);

        return Inertia::render('medical-records/Show', [
            'medicalRecord' => $medicalRecord,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'polyclinic', 'treatments', 'skincares']);

        $patients = Cache::remember('patient_options', 12 * 60 * 60, function () {
            return Patient::withCount('membership')->latest()->get();
        });
        $doctors = Cache::remember('doctor_options', 12 * 60 * 60, function () {
            return Doctor::latest()->get();
        });
        $treatments = Cache::remember('treatment_options', 12 * 60 * 60, function () {
            return Treatment::latest()->get();
        });
        $skincares = Cache::remember('skincare_options', 12 * 60 * 60, function () {
            return Skincare::latest()->get();
        });

        return Inertia::render('medical-records/Edit', [
            'medicalRecord' => $medicalRecord,
            'patients' => $patients,
            'doctors' => $doctors,
            'treatments' => $treatments,
            'skincares' => $skincares,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $treatments = $request->input('treatments', []);
        $skincares = $request->input('skincares', []);

        $medicalRecord->update($request->all());
        $medicalRecord->treatments()->sync($treatments);
        $medicalRecord->skincares()->sync($skincares);

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
