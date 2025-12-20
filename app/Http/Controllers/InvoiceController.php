<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['patient', 'appointment'])->latest()->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::where('status', 'مكتمل')->whereDoesntHave('invoice')->get();
        return view('invoices.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:غير مدفوع,مدفوع,مدفوع جزئياً',
            'payment_date' => 'nullable|date',
            'items' => 'nullable|array',
        ]);

        Invoice::create($validated);

        return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        $appointments = Appointment::where('status', 'مكتمل')->get();
        return view('invoices.edit', compact('invoice', 'patients', 'appointments'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:غير مدفوع,مدفوع,مدفوع جزئياً',
            'payment_date' => 'nullable|date',
            'items' => 'nullable|array',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index')->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }
}
