@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>إدارة الأطباء</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('doctors.create') }}" class="btn btn-primary">
                    ➕ إضافة طبيب جديد
                </a>
            </div>

            @if($doctors->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>التخصص</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $doctor)
                                <tr>
                                    <td>{{ $doctor->id }}</td>
                                    <td>{{ $doctor->name }}</td>
                                    <td>{{ $doctor->phone }}</td>
                                    <td>{{ $doctor->specialization }}</td>
                                    <td>
                                        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-warning">تعديل</a>
                                        <form method="POST" action="{{ route('doctors.destroy', $doctor) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $doctors->links() }}
                </div>
            @else
                <p class="text-center text-muted">لا يوجد أطباء مسجلين</p>
            @endif
        </div>
    </div>
@endsection