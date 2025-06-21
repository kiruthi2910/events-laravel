@extends('layout.app')

@section('content')
<div class="p-4" style="max-height: 100vh; overflow-y: auto; background-color: #f8f9fc;">
    <div class="container-fluid">
        <div class="card shadow-lg rounded-4 p-5 border-0 bg-white">

            {{-- Club Header Section --}}
            <div class="row align-items-center mb-5">
                @if ($club->logo)
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <img src="{{ asset('storage/' . $club->logo) }}" alt="Club Logo"
                             class="img-fluid rounded shadow-sm border"
                             style="max-height: 150px; object-fit: contain;">
                    </div>
                @endif
                <div class="col-md-9">
                    <h2 class="fw-bold" style="color: #003366;">{{ $club->club_name }}</h2>
                    <p class="text-muted"><i class="bi bi-calendar-event"></i> <strong>Founded:</strong> {{ $club->year_started }}</p>

                    <p class="mt-3">{{ $club->introduction ?? '—' }}</p>

                    <h5 class="fw-semibold mt-4" style="color: #003366;">Mission</h5>
                    <p>{{ $club->mission ?? '—' }}</p>
                </div>
            </div>

            <hr class="my-4">

            {{-- Staff Coordinator Section --}}
            <div class="row align-items-center mb-5">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    @if ($club->staff_coordinator_photo)
                        <img src="{{ asset('storage/' . $club->staff_coordinator_photo) }}"
                             class="rounded-circle shadow border"
                             width="140" height="140" alt="Staff Photo" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center shadow border"
                             style="width: 140px; height: 140px;">
                            <i class="bi bi-person fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <h4 class="fw-semibold" style="color: #003366;">Staff Coordinator</h4>
                    <h6 class="mb-1 mt-3">{{ $club->staff_coordinator_name }}</h6>
                    <p class="mb-0 text-muted"><i class="bi bi-envelope"></i> {{ $club->staff_coordinator_email }}</p>
                </div>
            </div>

            <hr class="my-4">

            {{-- Student Coordinators --}}
            <div>
                <h4 class="fw-semibold mb-4" style="color: #003366;">Student Coordinators</h4>
                <div class="row">
                    @forelse ($club->studentCoordinators as $student)
                        <div class="col-md-3 col-sm-4 col-6 mb-4 text-center">
                            <div class="d-flex flex-column align-items-center">
                                @if ($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" 
                                         class="rounded-circle shadow border mb-2"
                                         width="140" height="140"
                                         style="object-fit: cover;" 
                                         alt="Student Photo">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow border mb-2"
                                         style="width: 120px; height: 120px;">
                                        <i class="bi bi-person-circle fs-1 text-muted"></i>
                                    </div>
                                @endif
                                <p class="fw-medium text-dark mb-0">{{ $student->name }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No student coordinators listed.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
