<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');

        $query = Report::latest();

        if ($keyword) {
            $query->where('patient_name', 'LIKE', "%{$keyword}%")
                ->orWhere('patient_address', 'LIKE', "%{$keyword}%")
                ->orWhere('patient_phone', 'LIKE', "%{$keyword}%")
                ->orWhere('doctor_name', 'LIKE', "%{$keyword}%")
                ->orWhere('polyclinic_name', 'LIKE', "%{$keyword}%");
        }

        $reports = $query->paginate(10)->withQueryString();

        return Inertia::render('reports/Index', [
            'reports' => $reports,
        ]);
    }
}
