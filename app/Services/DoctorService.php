<?php

namespace App\Services;

use App\Repositories\PatientRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Log;


class DoctorService
{
    protected $repository;

    public function __construct(DoctorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllDoctors()
    {
        return $this->repository->getAll();
    }

    public function createDoctor(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateDoctor($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteDoctor($id)
    {
        return $this->repository->delete($id);
    }
}
 