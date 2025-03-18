@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Available Appointments</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach ($availabilities as $availability)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $availability->lecturer->name }}</h5>
                        <p class="card-text">
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($availability->date)->format('l, F j, Y') }} <br>
                            <strong>Time:</strong> {{ \Carbon\Carbon::parse($availability->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('g:i A') }} <br>
                            <strong>Status:</strong> {{ $availability->status }}
                        </p>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal{{ $availability->id }}">
                            Book Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for Booking Appointment -->
            <div class="modal fade" id="bookAppointmentModal{{ $availability->id }}" tabindex="-1" aria-labelledby="bookAppointmentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookAppointmentModalLabel">Book Appointment with {{ $availability->lecturer->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('student.appointments.book') }}">
                                @csrf
                                <input type="hidden" name="availability_id" value="{{ $availability->id }}">
                                <input type="hidden" name="lecturer_id" value="{{ $availability->lecturer->id }}">
                                <input type="hidden" name="student_id" value="{{ $student->id }}">

                                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($availability->date)->format('l, F j, Y') }}</p>
                                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($availability->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('g:i A') }}</p>
                                
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Select Appointment Date</label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required min="{{ now()->format('Y-m-d') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">Confirm Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
