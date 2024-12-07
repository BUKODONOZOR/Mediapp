<?php 

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;


class AppointmentRepository
{
    public function getAll()
    {
        return Appointment::all();
    }

    public function findById($id)
    {
        return Appointment::find($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $appointment = Appointment::create($data);
            return $appointment;
        });
    }

    public function update($id, array $data)
    {
        $appointment = $this->findById($id);
        return $appointment ? $appointment->update($data) : null;
    }

    public function delete($id)
    {
        $appointment = $this->findById($id);
        return $appointment ? $appointment->delete() : false;
    }

    public function findByDoctorAndDate($doctorId, $date)
    {
        return Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $date)
            ->get();
    }

    public function findByPatientAndReason($patientId, $reason)
    {
        return Appointment::where('patient_id', $patientId)
            ->where('reason', $reason)
            ->whereBetween('date', [now()->subMonths(2), now()])
            ->exists();
    }
}
