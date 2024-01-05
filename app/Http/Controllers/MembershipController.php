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
    public function index()
    {
        $memberships = Membership::with('patient')->latest()->get();
        $patients = Patient::doesntHave('membership')->latest()->get();

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
