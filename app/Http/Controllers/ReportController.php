<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function financial(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $totalRevenue = Invoice::where('payment_status', 'مدفوع')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');

        $pendingPayments = Invoice::where('payment_status', 'غير مدفوع')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $invoices = Invoice::with(['patient'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->paginate(20);

        return view('reports.financial', compact(
            'totalRevenue',
            'pendingPayments',
            'invoices',
            'startDate',
            'endDate'
        ));
    }

    public function medical(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $totalPatients = Patient::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalAppointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])->count();
        $completedAppointments = Appointment::where('status', 'مكتمل')
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->count();
        $cancelledAppointments = Appointment::where('status', 'ملغي')
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->count();

        return view('reports.medical', compact(
            'totalPatients',
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'startDate',
            'endDate'
        ));
    }
}
