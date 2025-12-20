<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor'])->latest('appointment_date');

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->paginate(15);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Check for conflicts
        if (
            Appointment::hasConflict(
                $validated['doctor_id'],
                $validated['appointment_date'],
                $validated['appointment_time']
            )
        ) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'الطبيب لديه موعد آخر في هذا الوقت. يرجى اختيار وقت آخر.'
            ]);
        }

        $validated['status'] = 'محجوز';
        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'تم حجز الموعد بنجاح');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'medicalRecord', 'invoice']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:محجوز,مكتمل,ملغي',
            'notes' => 'nullable|string',
        ]);

        // Check for conflicts (excluding current appointment)
        if (
            Appointment::hasConflict(
                $validated['doctor_id'],
                $validated['appointment_date'],
                $validated['appointment_time'],
                $appointment->id
            )
        ) {
            return back()->withInput()->withErrors([
                'appointment_time' => 'الطبيب لديه موعد آخر في هذا الوقت. يرجى اختيار وقت آخر.'
            ]);
        }

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'تم تحديث الموعد بنجاح');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'تم حذف الموعد بنجاح');
    }

    public function calendar()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', Carbon::today())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('appointments.calendar', compact('appointments'));
    }
}
