<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $patientsCount = Patient::count();
        $doctorsCount = Doctor::count();
        $todayAppointmentsCount = Appointment::whereDate('appointment_date', Carbon::today())->count();

        $monthlyRevenue = Invoice::where('payment_status', 'مدفوع')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');

        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', Carbon::today())
            ->where('status', 'محجوز')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'patientsCount',
            'doctorsCount',
            'todayAppointmentsCount',
            'monthlyRevenue',
            'upcomingAppointments'
        ));
    }
}
