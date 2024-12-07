<?php

namespace App\Http\Controllers;

use App\Services\PatientService;
use App\Services\DoctorService;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $service;

    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllPatients());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'document' => 'required|string|unique:patients',
            'email' => 'required|email|unique:patients',
            'name' => 'required|string',
            'age' => 'required|integer',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        return response()->json($this->service->createPatient($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'nullable|email|unique:patients,email,' . $id,
            'name' => 'nullable|string',
            'age' => 'nullable|integer',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        return response()->json($this->service->updatePatient($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->service->deletePatient($id));
    }
}

