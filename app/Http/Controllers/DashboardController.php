<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Polyclinic;
use App\Models\Treatment;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalDoctor = Doctor::count();
        $totalPatient = Patient::count();
        $totalTreatment = Treatment::count();
        $totalPolyclinic = Polyclinic::count();
        $totalMedicalRecord = MedicalRecord::count();

        return Inertia::render('Dashboard', [
            'entityCounts' => [
                'totalDoctor' => $totalDoctor,
                'totalPatient' => $totalPatient,
                'totalTreatment' => $totalTreatment,
                'totalPolyclinic' => $totalPolyclinic,
                'totalMedicalRecord' => $totalMedicalRecord,
            ]
        ]);
    }
}
