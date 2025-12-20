@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>📅 تقويم المواعيد</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">العودة للقائمة</a>
                <a href="{{ route('appointments.create') }}" class="btn btn-primary">حجز موعد جديد</a>
            </div>

            @if($appointments->count() > 0)
                @php
                    $groupedAppointments = $appointments->groupBy(function ($appointment) {
                        return $appointment->appointment_date->format('Y-m-d');
                    });
                @endphp

                @foreach($groupedAppointments as $date => $dayAppointments)
                    <div class="card mb-3">
                        <div class="card-header"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <h5 class="mb-0">{{ \Carbon\Carbon::parse($date)->isoFormat('dddd، D MMMM YYYY') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($dayAppointments->sortBy('appointment_time') as $appointment)
                                    <div class="col-md-4 mb-3">
                                        <div class="border rounded p-3" style="background: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</h6>
                                                @if($appointment->status == 'محجوز')
                                                    <span class="badge bg-info">{{ $appointment->status }}</span>
                                                @elseif($appointment->status == 'مكتمل')
                                                    <span class="badge bg-success">{{ $appointment->status }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $appointment->status }}</span>
                                                @endif
                                            </div>
                                            <p class="mb-1"><strong>المريض:</strong> {{ $appointment->patient->name }}</p>
                                            <p class="mb-1"><strong>الطبيب:</strong> {{ $appointment->doctor->name }}</p>
                                            <p class="mb-1 text-muted small">{{ $appointment->doctor->specialization }}</p>
                                            @if($appointment->notes)
                                                <p class="mb-2 small"><strong>ملاحظات:</strong> {{ Str::limit($appointment->notes, 50) }}
                                                </p>
                                            @endif
                                            <div class="mt-2">
                                                <a href="{{ route('appointments.show', $appointment) }}"
                                                    class="btn btn-sm btn-info">عرض</a>
                                                <a href="{{ route('appointments.edit', $appointment) }}"
                                                    class="btn btn-sm btn-warning">تعديل</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info text-center">
                    <h5>لا توجد مواعيد قادمة</h5>
                    <p>يمكنك حجز موعد جديد الآن</p>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">حجز موعد</a>
                </div>
            @endif
        </div>
    </div>
@endsection