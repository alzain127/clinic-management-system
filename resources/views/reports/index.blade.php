@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>التقارير</h1>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i style="font-size: 4rem;">💰</i>
                    </div>
                    <h4>التقارير المالية</h4>
                    <p class="text-muted">عرض تقارير الإيرادات والمدفوعات</p>
                    <a href="{{ route('reports.financial') }}" class="btn btn-primary">
                        عرض التقرير المالي
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i style="font-size: 4rem;">📊</i>
                    </div>
                    <h4>التقارير الطبية</h4>
                    <p class="text-muted">إحصائيات المرضى والمواعيد</p>
                    <a href="{{ route('reports.medical') }}" class="btn btn-primary">
                        عرض التقرير الطبي
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection