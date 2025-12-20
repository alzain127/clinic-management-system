@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>إنشاء فاتورة جديدة</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('invoices.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="patient_id" class="form-label">المريض *</label>
                        <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id"
                            name="patient_id" required>
                            <option value="">اختر المريض</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} - {{ $patient->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="appointment_id" class="form-label">الموعد (اختياري)</label>
                        <select class="form-select @error('appointment_id') is-invalid @enderror" id="appointment_id"
                            name="appointment_id">
                            <option value="">بدون موعد</option>
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                    {{ $appointment->patient->name }} - {{ $appointment->doctor->name }} -
                                    {{ $appointment->appointment_date->format('Y-m-d') }}
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="amount" class="form-label">المبلغ (ج.س) *</label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                            id="amount" name="amount" value="{{ old('amount') }}" required min="0">
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="payment_status" class="form-label">حالة الدفع *</label>
                        <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status"
                            name="payment_status" required>
                            <option value="">اختر الحالة</option>
                            <option value="غير مدفوع" {{ old('payment_status') == 'غير مدفوع' ? 'selected' : '' }}>غير مدفوع
                            </option>
                            <option value="مدفوع" {{ old('payment_status') == 'مدفوع' ? 'selected' : '' }}>مدفوع</option>
                            <option value="مدفوع جزئياً" {{ old('payment_status') == 'مدفوع جزئياً' ? 'selected' : '' }}>مدفوع
                                جزئياً</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="payment_date" class="form-label">تاريخ الدفع</label>
                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date"
                        name="payment_date" value="{{ old('payment_date') }}">
                    @error('payment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">اتركه فارغاً إذا لم يتم الدفع بعد</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">حفظ الفاتورة</button>
                </div>
            </form>
        </div>
    </div>
@endsection