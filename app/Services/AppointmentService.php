<?php

namespace App\Services;

use App\Repositories\PatientRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Log;


class AppointmentService
{
    protected $repository;

    public function __construct(AppointmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllAppointments()
    {
        return $this->repository->getAll();
    }

    public function createAppointment(array $data)
    {
        $doctorAppointments = $this->repository->findByDoctorAndDate($data['doctor_id'], $data['date']);
        
        if ($doctorAppointments->where('time', $data['time'])->count() > 0) {
            throw new \Exception('Conflict: This doctor already has an appointment at this time.');
        }

        if ($this->repository->findByPatientAndReason($data['patient_id'], $data['reason'])) {
            throw new \Exception('Conflict: This patient already has an appointment for the same reason in the last 2 months.');
        }

        return $this->repository->create($data);
    }

    public function updateAppointment($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteAppointment($id)
    {
        return $this->repository->delete($id);
    }
}
