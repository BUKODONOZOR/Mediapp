<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Doctor;  // Asegúrate de que tienes el modelo Doctor para acceder a la base de datos

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar las credenciales del usuario
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Enviar una solicitud de autenticación al backend
        $response = Http::post('http://localhost:8080/api/auth/login', [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // Verificar si la respuesta es exitosa
        if ($response->successful()) {
            $responseData = $response->json();

            // Extraer el token y el mensaje de la respuesta
            $token = $responseData['token'] ?? null;
            $message = $responseData['message'] ?? '';
            $role = str_contains($message, 'doctor') ? 'doctor' : 'patient';

            // Si no hay token, retornar con error
            if (!$token) {
                return back()->with('error', 'Unable to authenticate user. Token missing.');
            }

            // Obtener los detalles del paciente si el rol es "patient"
            if ($role === 'patient') {
                $patient = \App\Models\Patient::where('email', $validated['email'])->first();
                $patientId = $patient ? $patient->id : null;

                // Guardar los datos del paciente en la sesión
                Session::put('user', [
                    'name' => $validated['email'],
                    'role' => $role,
                    'id' => $patientId,
                ]);
            }

            // Obtener los detalles del doctor si el rol es "doctor"
            if ($role === 'doctor') {
                $doctor = Doctor::where('email', $validated['email'])->first();
                $doctorId = $doctor ? $doctor->id : null;

                // Guardar los datos del doctor en la sesión
                Session::put('user', [
                    'name' => $validated['email'],
                    'role' => $role,
                    'id' => $doctorId,
                ]);
            }

            // Guardar el token en la sesión
            Session::put('token', $token);

            // Redirigir según el rol
            if ($role === 'doctor') {
                return redirect()->route('doctor.home');
            } else {
                return redirect()->route('patient.home');
            }
        }

        // Si la autenticación falla
        return back()->with('error', 'Invalid credentials or unable to login.');
    }
}
