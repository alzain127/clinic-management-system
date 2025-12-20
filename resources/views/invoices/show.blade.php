@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>تفاصيل الفاتورة #{{ $invoice->id }}</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">معلومات الفاتورة</h5>
                </div>
                <div class="card-body">
                    <p><strong>رقم الفاتورة:</strong> #{{ $invoice->id }}</p>
                    <p><strong>المريض:</strong> {{ $invoice->patient->name }}</p>
                    <p><strong>هاتف المريض:</strong> {{ $invoice->patient->phone }}</p>

                    @if($invoice->appointment)
                        <p><strong>الموعد:</strong> {{ $invoice->appointment->appointment_date->format('Y-m-d') }} -
                            {{ \Carbon\Carbon::parse($invoice->appointment->appointment_time)->format('H:i') }}</p>
                        <p><strong>الطبيب:</strong> {{ $invoice->appointment->doctor->name }}</p>
                    @else
                        <p><strong>الموعد:</strong> غير مرتبط بموعد</p>
                    @endif

                    <hr>

                    <p><strong>المبلغ:</strong> <span class="h4 text-success">{{ number_format($invoice->amount, 2) }}
                            ر.س</span></p>

                    <p><strong>حالة الدفع:</strong>
                        @if($invoice->payment_status == 'مدفوع')
                            <span class="badge bg-success fs-6">{{ $invoice->payment_status }}</span>
                        @elseif($invoice->payment_status == 'مدفوع جزئياً')
                            <span class="badge bg-warning fs-6">{{ $invoice->payment_status }}</span>
                        @else
                            <span class="badge bg-danger fs-6">{{ $invoice->payment_status }}</span>
                        @endif
                    </p>

                    @if($invoice->payment_date)
                        <p><strong>تاريخ الدفع:</strong> {{ $invoice->payment_date->format('Y-m-d') }}</p>
                    @endif

                    <p><strong>تاريخ الإنشاء:</strong> {{ $invoice->created_at->format('Y-m-d H:i') }}</p>

                    <div class="mt-4">
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning w-100 mb-2">تعديل
                            الفاتورة</a>
                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary w-100">العودة للقائمة</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($invoice->items)
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">بنود الفاتورة</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>البند</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->items as $item)
                                        <tr>
                                            <td>{{ $item['name'] ?? '-' }}</td>
                                            <td>{{ $item['quantity'] ?? '-' }}</td>
                                            <td>{{ number_format($item['price'] ?? 0, 2) }} ر.س</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">ملخص الدفع</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>المبلغ الإجمالي:</span>
                        <strong>{{ number_format($invoice->amount, 2) }} ر.س</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>الحالة:</span>
                        <strong>{{ $invoice->payment_status }}</strong>
                    </div>

                    @if($invoice->payment_status == 'مدفوع')
                        <div class="alert alert-success mt-3 mb-0">
                            <i class="bi bi-check-circle"></i> تم الدفع بالكامل
                        </div>
                    @elseif($invoice->payment_status == 'غير مدفوع')
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="bi bi-exclamation-circle"></i> لم يتم الدفع بعد
                        </div>
                    @else
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="bi bi-info-circle"></i> تم الدفع جزئياً
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection