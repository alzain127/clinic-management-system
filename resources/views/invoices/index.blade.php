@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>إدارة الفواتير</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    ➕ إنشاء فاتورة جديدة
                </a>
            </div>

            @if($invoices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المريض</th>
                                <th>المبلغ</th>
                                <th>حالة الدفع</th>
                                <th>تاريخ الدفع</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->id }}</td>
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
                                    <td>
                                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">عرض</a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">تعديل</a>
                                        <form method="POST" action="{{ route('invoices.destroy', $invoice) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $invoices->links() }}
                </div>
            @else
                <p class="text-center text-muted">لا توجد فواتير</p>
            @endif
        </div>
    </div>
@endsection