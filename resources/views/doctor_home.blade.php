<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home</title>
</head>
<body>
    <h1>Welcome, Dr. {{ $name }}</h1>

    <h2>Assigned Appointments</h2>

    @if (session('success'))
        <div>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <ul>
        @foreach ($appointments as $appointment)
            <li>
                {{ $appointment->date }} - {{ $appointment->reason }} - Status: {{ $appointment->status }}
                
                <!-- Formulario para actualizar el estado de la cita -->
                <form action="{{ route('doctor.appointments.update_status', $appointment->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <select name="status" required>
                        <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
