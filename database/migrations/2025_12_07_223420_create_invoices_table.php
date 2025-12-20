<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_status', ['غير مدفوع', 'مدفوع', 'مدفوع جزئياً'])->default('غير مدفوع'); // Unpaid, Paid, Partially Paid
            $table->date('payment_date')->nullable();
            $table->json('items')->nullable(); // Store invoice line items as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
