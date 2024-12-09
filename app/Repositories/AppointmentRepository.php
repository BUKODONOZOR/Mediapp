<?php

namespace App\Repositories;

use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentRepository




{

    public function getAppointmentsByPatient($patientId)
    {
        return Appointment::where('patient_id', $patientId)->get();
    }
    
    public function hasTimeConflict(string $date, string $time, int $doctorId): bool
    {
        $appointmentTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);

        return Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $date)
            ->where(function ($query) use ($appointmentTime) {
                $query->whereBetween('time', [
                    $appointmentTime->subHour()->format('H:i'),
                    $appointmentTime->addHour()->format('H:i'),
                ]);
            })
            ->exists();
    }

    public function hasMedicalProblemConflict(string $details, int $patientId): bool
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        return Appointment::where('patient_id', $patientId)
            ->where('details', $details)
            ->where('date', '>=', $oneMonthAgo->format('Y-m-d'))
            ->exists();
    }
}
