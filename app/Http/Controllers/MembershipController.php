<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMembershipRequest;
use App\Models\Membership;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $column = $request->query('column');
        $keyword = $request->query('keyword');

        $patients = Patient::doesntHave('membership')->latest()->get();

        $query = Membership::with('patient')->latest();

        if (!$column) {
            $query->whereHas('patient', function ($query) use ($keyword) {
                $query->where('registrasion_number', 'LIKE', "%{$keyword}%")
                    ->orWhere('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('age', 'LIKE', "%{$keyword}%")
                    ->orWhere('gender', 'LIKE', "%{$keyword}%")
                    ->orWhere('skin_type', 'LIKE', "%{$keyword}%")
                    ->orWhere('address', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%");
            });
        } else {
            $query->whereHas('patient', function ($query) use ($column, $keyword) {
                $query->where($column, 'LIKE', "%{$keyword}%");
            });
        }

        $memberships = $query->get();

        return Inertia::render('memberships/Index', [
            'memberships' => $memberships,
            'patients' => $patients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMembershipRequest $request)
    {
        Membership::create($request->all());

        return to_route('memberships.index');
    }

    public function addBalance(Request $request, Membership $membership)
    {
        $request->validate(['payload' => ['required', 'numeric']]);

        $payload = (int) $request->input('payload', 0);

        $membership->balance += $payload;
        $membership->save();

        return to_route('memberships.index');
    }

    public function useBalance(Request $request, Membership $membership)
    {
        $request->validate(['payload' => ['required', 'numeric']]);

        $payload = (int) $request->input('payload', 0);

        if ($payload > $membership->balance) {
            return back()->withErrors([
                'payload' => 'Jumlah saldo tidak cukup.',
            ])->onlyInput('payload');
        }

        $membership->balance -= $payload;
        $membership->save();

        return to_route('memberships.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        $membership->delete();

        return to_route('memberships.index');
    }
}
