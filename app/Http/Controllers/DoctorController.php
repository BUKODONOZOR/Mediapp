<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Appointment; 

class DoctorController extends Controller
{
    public function home()
    {

        $doctorId = session('user.id');

        $userRole = session('user')['role'] ?? null;

        if ($userRole !== 'doctor') {
            return redirect('/')->withErrors(['error' => 'Unauthorized access']);
        }

        $response = Http::get('http://localhost:8080/api/appointments/doctor', [
            'Authorization' => 'Bearer ' . session('token'),
        ]);

        $appointments = Appointment::where('doctor_id', $doctorId)->get();

        return view('doctor_home', [
            'name' => session('user.name'),
            'appointments' => $appointments,
        ]);
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        $userRole = session('user')['role'] ?? null;

        if ($userRole !== 'doctor') {
            return redirect('/')->withErrors(['error' => 'Unauthorized access']);
        }

        $validated = $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled',
        ]);

        $response = Http::patch("http://localhost:8080/api/appointments/{$id}/status", [
            'status' => $validated['status'],
        ], [
            'Authorization' => 'Bearer ' . session('token'),
        ]);

        if ($response->successful()) {
            return redirect()->route('doctor.home')->with('success', 'Appointment status updated successfully!');
        }

        return back()->withErrors(['error' => $response->body()]);
    }
} 


