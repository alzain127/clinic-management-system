@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>إدارة المواعيد</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        ➕ حجز موعد جديد
                    </a>
                    <a href="{{ route('appointments.calendar') }}" class="btn btn-outline-primary">
                        📅 عرض التقويم
                    </a>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('appointments.index') }}" class="d-flex">
                        <input type="date" name="date" class="form-control me-2" value="{{ request('date') }}">
                        <button type="submit" class="btn btn-outline-primary">بحث</button>
                    </form>
                </div>
            </div>

            @if($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المريض</th>
                                <th>الطبيب</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->id }}</td>
                                    <td>{{ $appointment->patient->name }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                    <td>
                                        @if($appointment->status == 'محجوز')
                                            <span class="badge bg-info">{{ $appointment->status }}</span>
                                        @elseif($appointment->status == 'مكتمل')
                                            <span class="badge bg-success">{{ $appointment->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $appointment->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">عرض</a>
                                        <a href="{{ route('appointments.edit', $appointment) }}"
                                            class="btn btn-sm btn-warning">تعديل</a>
                                        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $appointments->links() }}
                </div>
            @else
                <p class="text-center text-muted">لا توجد مواعيد</p>
            @endif
        </div>
    </div>
@endsection