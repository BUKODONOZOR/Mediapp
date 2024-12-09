<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Appointment; 
use App\Services\PatientService;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{

    protected $service;

    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    public function home()
{
        // Obtener el usuario de la sesión
        $user = Session::get('user');
        $patientId = $user['id'] ?? null;
    
        // Verificar si el paciente está registrado
        if (!$patientId) {
            return redirect()->route('login')->with('error', 'Patient ID not found.');
        }
    
        // Obtener las citas del paciente
        $appointments = \App\Models\Appointment::where('patient_id', $patientId)->get();
    
        // Pasar los datos a la vista
        return view('patient_home', [
            'name' => $user['name'],
            'patientId' => $patientId,
            'appointments' => $appointments,  // Pasar las citas a la vista
        ]);
}


    
    public function findByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $patient = $this->service->findPatientByEmail($request->input('email'));

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    
} 

