<?php

namespace App\Observers;

use App\Models\MedicalRecord;

class MedicalRecordObserver
{
    /**
     * Handle the MedicalRecord "created" event.
     */
    public function created(MedicalRecord $medicalRecord): void
    {
        // 
    }

    /**
     * Handle the MedicalRecord "updated" event.
     */
    public function updated(MedicalRecord $medicalRecord): void
    {
        //
    }

    /**
     * Handle the MedicalRecord "deleted" event.
     */
    public function deleted(MedicalRecord $medicalRecord): void
    {
        //
    }

    /**
     * Handle the MedicalRecord "restored" event.
     */
    public function restored(MedicalRecord $medicalRecord): void
    {
        //
    }

    /**
     * Handle the MedicalRecord "force deleted" event.
     */
    public function forceDeleted(MedicalRecord $medicalRecord): void
    {
        //
    }
}
