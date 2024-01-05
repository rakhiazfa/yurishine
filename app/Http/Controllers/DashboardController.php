<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Polyclinic;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalDoctor = Doctor::count();
        $totalPatient = Patient::count();
        $totalMedicine = Medicine::count();
        $totalPolyclinic = Polyclinic::count();
        $totalMedicalRecord = MedicalRecord::count();

        return Inertia::render('Dashboard', [
            'entityCounts' => [
                'totalDoctor' => $totalDoctor,
                'totalPatient' => $totalPatient,
                'totalMedicine' => $totalMedicine,
                'totalPolyclinic' => $totalPolyclinic,
                'totalMedicalRecord' => $totalMedicalRecord,
            ]
        ]);
    }
}
