<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'duty_schedule' => 'nullable|array',
        ]);

        Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'تم إضافة الطبيب بنجاح');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['appointments.patient', 'medicalRecords.patient']);
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'duty_schedule' => 'nullable|array',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.index')->with('success', 'تم تحديث بيانات الطبيب بنجاح');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'تم حذف الطبيب بنجاح');
    }
}
