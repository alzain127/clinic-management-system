@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>{{ isset($doctor) ? 'تعديل بيانات الطبيب' : 'إضافة طبيب جديد' }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ isset($doctor) ? route('doctors.update', $doctor) : route('doctors.store') }}">
                @csrf
                @if(isset($doctor))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">اسم الطبيب *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $doctor->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">رقم الهاتف *</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                            value="{{ old('phone', $doctor->phone ?? '') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="specialization" class="form-label">التخصص *</label>
                    <input type="text" class="form-control @error('specialization') is-invalid @enderror"
                        id="specialization" name="specialization"
                        value="{{ old('specialization', $doctor->specialization ?? '') }}" required>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">{{ isset($doctor) ? 'تحديث' : 'حفظ' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection