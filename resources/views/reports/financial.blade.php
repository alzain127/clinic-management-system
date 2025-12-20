@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>💰 التقرير المالي</h1>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.financial') }}" class="row align-items-end">
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
        <div class="col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div>💰 إجمالي الإيرادات</div>
                <h3>{{ number_format($totalRevenue ?? 0, 2) }} ج.س</h3>
                <small>المبالغ المدفوعة فعلياً</small>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div>⏳ المدفوعات المعلقة</div>
                <h3>{{ number_format($pendingPayments ?? 0, 2) }} ج.س</h3>
                <small>الفواتير غير المدفوعة</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">تفاصيل الفواتير</h5>
        </div>
        <div class="card-body">
            @if(isset($invoices) && $invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>التاريخ</th>
                                <th>المريض</th>
                                <th>المبلغ</th>
                                <th>حالة الدفع</th>
                                <th>تاريخ الدفع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $invoice->patient->name }}</td>
                                    <td>{{ number_format($invoice->amount, 2) }} ج.س</td>
                                    <td>
                                        @if($invoice->payment_status == 'مدفوع')
                                            <span class="badge bg-success">{{ $invoice->payment_status }}</span>
                                        @elseif($invoice->payment_status == 'مدفوع جزئياً')
                                            <span class="badge bg-warning">{{ $invoice->payment_status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $invoice->payment_status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice->payment_date ? $invoice->payment_date->format('Y-m-d') : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $invoices->links() }}
                </div>
            @else
                <p class="text-center text-muted">لا توجد فواتير في هذه الفترة</p>
            @endif
        </div>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">العودة للتقارير</a>
    </div>
@endsection