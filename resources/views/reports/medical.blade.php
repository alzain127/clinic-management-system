@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>📊 التقرير الطبي</h1>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.medical') }}" class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="start_date" class="form-label">من تاريخ</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ request('start_date', $startDate) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="end_date" class="form-label">إلى تاريخ</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="{{ request('end_date', $endDate) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100">عرض التقرير</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div>👥 المرضى الجدد</div>
                <h3>{{ $totalPatients ?? 0 }}</h3>
                <small>في الفترة المحددة</small>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div>📅 إجمالي المواعيد</div>
                <h3>{{ $totalAppointments ?? 0 }}</h3>
                <small>جميع المواعيد</small>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div>✅ المواعيد المكتملة</div>
                <h3>{{ $completedAppointments ?? 0 }}</h3>
                <small>تم إنجازها</small>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div>❌ المواعيد الملغاة</div>
                <h3>{{ $cancelledAppointments ?? 0 }}</h3>
                <small>تم إلغاؤها</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">نسب حالات المواعيد</h5>
                </div>
                <div class="card-body">
                    @php
                        $total = ($totalAppointments ?? 0);
                        $completedPercent = $total > 0 ? round(($completedAppointments ?? 0) / $total * 100, 1) : 0;
                        $cancelledPercent = $total > 0 ? round(($cancelledAppointments ?? 0) / $total * 100, 1) : 0;
                        $bookedPercent = $total > 0 ? round(100 - $completedPercent - $cancelledPercent, 1) : 0;
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>مكتمل</span>
                            <span>{{ $completedPercent }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ $completedPercent }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>محجوز</span>
                            <span>{{ $bookedPercent }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: {{ $bookedPercent }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>ملغي</span>
                            <span>{{ $cancelledPercent }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width: {{ $cancelledPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">ملخص الإحصائيات</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 pb-3 border-bottom">
                        <h6>معدل الإنجاز</h6>
                        <h4 class="text-success">{{ $completedPercent }}%</h4>
                        <small class="text-muted">من إجمالي المواعيد</small>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <h6>معدل الإلغاء</h6>
                        <h4 class="text-danger">{{ $cancelledPercent }}%</h4>
                        <small class="text-muted">من إجمالي المواعيد</small>
                    </div>

                    <div>
                        <h6>متوسط المرضى الجدد</h6>
                        <h4 class="text-primary">
                            @php
                                $days = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) ?: 1;
                                $avgPatients = round(($totalPatients ?? 0) / $days, 1);
                            @endphp
                            {{ $avgPatients }}
                        </h4>
                        <small class="text-muted">مريض جديد يومياً</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">العودة للتقارير</a>
    </div>
@endsection