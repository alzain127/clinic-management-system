@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>حجز موعد جديد</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('appointments.store') }}">
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
                        <label for="doctor_id" class="form-label">الطبيب *</label>
                        <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id"
                            required>
                            <option value="">اختر الطبيب</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} - {{ $doctor->specialization }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="appointment_date" class="form-label">تاريخ الموعد *</label>
                        <input type="date" class="form-control @error('appointment_date') is-invalid @enderror"
                            id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required
                            min="{{ date('Y-m-d') }}">
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="appointment_time" class="form-label">وقت الموعد *</label>
                        <input type="time" class="form-control @error('appointment_time') is-invalid @enderror"
                            id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">ملاحظات</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                        rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">حجز الموعد</button>
                </div>
            </form>
        </div>
    </div>
@endsection