<?php

namespace App\Providers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Observers\MedicalRecordObserver;
use App\Observers\PatientObserver;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Patient::observe(PatientObserver::class);
        MedicalRecord::observe(MedicalRecordObserver::class);

        Inertia::share([
            'urlPrevious' => url()->previous(),
        ]);
    }
}
