@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>لوحة التحكم</h1>
        <p class="mb-0">مرحباً {{ Auth::user()->name }} - {{ Auth::user()->role }}</p>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="stat-card">
                <div>👥 المرضى</div>
                <h3>{{ $patientsCount ?? 0 }}</h3>
                <a href="{{ route('patients.index') }}" class="text-white text-decoration-none">عرض الكل ←</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div>👨‍⚕️ الأطباء</div>
                <h3>{{ $doctorsCount ?? 0 }}</h3>
                <a href="{{ route('doctors.index') }}" class="text-white text-decoration-none">عرض الكل ←</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div>📅 المواعيد اليوم</div>
                <h3>{{ $todayAppointmentsCount ?? 0 }}</h3>
                <a href="{{ route('appointments.index') }}" class="text-white text-decoration-none">عرض الكل ←</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div>💰 الإيرادات الشهرية</div>
                <h3>{{ number_format($monthlyRevenue ?? 0, 2) }} ر.س</h3>
                <a href="{{ route('reports.index') }}" class="text-white text-decoration-none">عرض التقارير ←</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">المواعيد القادمة</h5>
                </div>
                <div class="card-body">
                    @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>المريض</th>
                                        <th>الطبيب</th>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingAppointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->patient->name }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td>{{ $appointment->appointment_date->format('Y-m-d') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                            <td><span class="badge bg-info">{{ $appointment->status }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">لا توجد مواعيد قادمة</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">روابط سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('patients.create') }}" class="btn btn-outline-primary">
                            ➕ إضافة مريض جديد
                        </a>
                        <a href="{{ route('appointments.create') }}" class="btn btn-outline-primary">
                            📅 حجز موعد جديد
                        </a>
                        <a href="{{ route('invoices.create') }}" class="btn btn-outline-primary">
                            💰 إنشاء فاتورة جديدة
                        </a>
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-primary">
                            📊 عرض التقارير
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection