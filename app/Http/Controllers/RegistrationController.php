<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Doctor;
use App\Models\Patient;

class RegistrationController extends Controller
{
    public function showPatientForm()
    {
        return view('register_patient');
    }

    public function showDoctorForm()
    {
        return view('register_doctor');
    }

    public function registerPatient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'age' => 'required|integer',
            'document' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
        ]);

        $response = Http::post('http://localhost:8080/api/auth/register', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'PATIENT',
        ]);

        if ($response->successful()) {
            Patient::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'age' => $validated['age'],
                'document' => $validated['document'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
            ]);

            return redirect()->route('register.patient.form')->with('success', 'Patient registered successfully!');
        }

        return back()->withErrors(['error' => $response->body()])->withInput();
    }

    public function registerDoctor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'specialty' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $response = Http::post('http://localhost:8080/api/auth/register', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'DOCTOR',
        ]);

        if ($response->successful()) {
            Doctor::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'specialty' => $validated['specialty'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);

            return redirect()->route('register.doctor.form')->with('success', 'Doctor registered successfully!');
        }

        return back()->withErrors(['error' => $response->body()])->withInput();
    }
}
