<?php

namespace App\Services;

use App\Repositories\PatientRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Log;

class PatientService
{
    protected $repository;

    public function __construct(PatientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPatients()
    {
        return $this->repository->getAll();
    }

    public function createPatient(array $data)
    {
        return $this->repository->create($data);
    }

    public function updatePatient($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deletePatient($id)
    {
        return $this->repository->delete($id);
    }
}


