@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>تفاصيل الموعد #{{ $appointment->id }}</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">معلومات الموعد</h5>
                </div>
                <div class="card-body">
                    <p><strong>المريض:</strong> {{ $appointment->patient->name }}</p>
                    <p><strong>هاتف المريض:</strong> {{ $appointment->patient->phone }}</p>
                    <p><strong>الطبيب:</strong> {{ $appointment->doctor->name }}</p>
                    <p><strong>التخصص:</strong> {{ $appointment->doctor->specialization }}</p>
                    <p><strong>التاريخ:</strong> {{ $appointment->appointment_date->format('Y-m-d') }}</p>
                    <p><strong>الوقت:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                    </p>
                    <p><strong>الحالة:</strong>
                        @if($appointment->status == 'محجوز')
                            <span class="badge bg-info">{{ $appointment->status }}</span>
                        @elseif($appointment->status == 'مكتمل')
                            <span class="badge bg-success">{{ $appointment->status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $appointment->status }}</span>
                        @endif
                    </p>
                    @if($appointment->notes)
                        <p><strong>ملاحظات:</strong><br>{{ $appointment->notes }}</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">تعديل الموعد</a>
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">العودة للقائمة</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($appointment->medicalRecord)
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">السجل الطبي</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>التشخيص:</strong><br>{{ $appointment->medicalRecord->diagnosis }}</p>
                        @if($appointment->medicalRecord->prescription)
                            <p><strong>الوصفة الطبية:</strong><br>{{ $appointment->medicalRecord->prescription }}</p>
                        @endif
                        @if($appointment->medicalRecord->notes)
                            <p><strong>ملاحظات:</strong><br>{{ $appointment->medicalRecord->notes }}</p>
                        @endif
                    </div>
                </div>
            @endif

            @if($appointment->invoice)
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">الفاتورة</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>رقم الفاتورة:</strong> #{{ $appointment->invoice->id }}</p>
                        <p><strong>المبلغ:</strong> {{ number_format($appointment->invoice->amount, 2) }} ر.س</p>
                        <p><strong>حالة الدفع:</strong>
                            @if($appointment->invoice->payment_status == 'مدفوع')
                                <span class="badge bg-success">{{ $appointment->invoice->payment_status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $appointment->invoice->payment_status }}</span>
                            @endif
                        </p>
                        @if($appointment->invoice->payment_date)
                            <p><strong>تاريخ الدفع:</strong> {{ $appointment->invoice->payment_date->format('Y-m-d') }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection