@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>معلومات المريض: {{ $patient->name }}</h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">البيانات الأساسية</h5>
                </div>
                <div class="card-body">
                    <p><strong>الاسم:</strong> {{ $patient->name }}</p>
                    <p><strong>الهاتف:</strong> {{ $patient->phone }}</p>
                    <p><strong>العنوان:</strong> {{ $patient->address ?? '-' }}</p>
                    <p><strong>الجنس:</strong> {{ $patient->gender }}</p>
                    <p><strong>تاريخ الميلاد:</strong> {{ $patient->birth_date->format('Y-m-d') }}</p>
                    <p><strong>فصيلة الدم:</strong> {{ $patient->blood_type ?? '-' }}</p>
                    <p><strong>التاريخ المرضي:</strong><br>{{ $patient->medical_history ?? 'لا يوجد' }}</p>

                    <div class="mt-3">
                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning w-100 mb-2">تعديل
                            البيانات</a>
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary w-100">العودة للقائمة</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">المواعيد السابقة</h5>
                </div>
                <div class="card-body">
                    @if($patient->appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>الطبيب</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td><span class="badge bg-info">{{ $appointment->status }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">لا توجد مواعيد</p>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">السجلات الطبية</h5>
                </div>
                <div class="card-body">
                    @if($patient->medicalRecords->count() > 0)
                        @foreach($patient->medicalRecords as $record)
                            <div class="border-bottom pb-3 mb-3">
                                <p><strong>التاريخ:</strong> {{ $record->created_at->format('Y-m-d') }}</p>
                                <p><strong>الطبيب:</strong> {{ $record->doctor->name }}</p>
                                <p><strong>التشخيص:</strong> {{ $record->diagnosis }}</p>
                                @if($record->prescription)
                                    <p><strong>الوصفة الطبية:</strong> {{ $record->prescription }}</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">لا توجد سجلات طبية</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">الفواتير</h5>
                </div>
                <div class="card-body">
                    @if($patient->invoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>الرقم</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الدفع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->invoices as $invoice)
                                        <tr>
                                            <td>#{{ $invoice->id }}</td>
                                            <td>{{ number_format($invoice->amount, 2) }} ر.س</td>
                                            <td><span
                                                    class="badge bg-{{ $invoice->payment_status == 'مدفوع' ? 'success' : 'danger' }}">{{ $invoice->payment_status }}</span>
                                            </td>
                                            <td>{{ $invoice->payment_date ? $invoice->payment_date->format('Y-m-d') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">لا توجد فواتير</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection