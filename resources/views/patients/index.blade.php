@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>إدارة المرضى</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">
                        ➕ إضافة مريض جديد
                    </a>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('patients.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="بحث عن مريض..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">بحث</button>
                    </form>
                </div>
            </div>

            @if($patients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>الجنس</th>
                                <th>تاريخ الميلاد</th>
                                <th>فصيلة الدم</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $patient)
                                <tr>
                                    <td>{{ $patient->id }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->phone }}</td>
                                    <td>{{ $patient->gender }}</td>
                                    <td>{{ $patient->birth_date->format('Y-m-d') }}</td>
                                    <td>{{ $patient->blood_type ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-info">عرض</a>
                                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-warning">تعديل</a>
                                        <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا المريض؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $patients->links() }}
                </div>
            @else
                <p class="text-center text-muted">لا يوجد مرضى مسجلين</p>
            @endif
        </div>
    </div>
@endsection