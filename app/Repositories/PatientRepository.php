<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class PatientRepository
{
    public function getAll()
    {
        return Patient::all();
    }

    public function findById($id)
    {
        return Patient::find($id);
    }

    public function create(array $data)
    {
        return Patient::create($data);
    }

    public function update($id, array $data)
    {
        $patient = $this->findById($id);
        return $patient ? $patient->update($data) : null;
    }

    public function delete($id)
    {
        $patient = $this->findById($id);
        return $patient ? $patient->delete() : false;
    }
}
