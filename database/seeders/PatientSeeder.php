<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'name' => 'أحمد محمد علي',
                'phone' => '0901234567',
                'address' => 'الخرطوم, الرياض',
                'gender' => 'ذكر',
                'birth_date' => '1990-09-15',
                'blood_type' => 'O+',
                'medical_history' => 'لا يوجد أمراض مزمنة',
            ],
            [
                'name' => 'فاطمة عبدالله',
                'phone' => '0909876543',
                'address' => 'الخرطوم, الرياض',
                'gender' => 'أنثى',
                'birth_date' => '1985-08-20',
                'blood_type' => 'A+',
                'medical_history' => 'ضغط دم مرتفع',
            ],
            [
                'name' => 'خالد سعيد',
                'phone' => '0951112233',
                'address' => 'الخرطوم, الرياض',
                'gender' => 'ذكر',
                'birth_date' => '2000-12-10',
                'blood_type' => 'B+',
                'medical_history' => null,
            ],
            [
                'name' => 'امل إبراهيم',
                'phone' => '0954445566',
                'address' => 'الخرطوم, الرياض',
                'gender' => 'أنثى',
                'birth_date' => '1995-03-25',
                'blood_type' => 'AB+',
                'medical_history' => 'حساسية من البنسلين',
            ],
            [
                'name' => 'عمر حسن',
                'phone' => '0907778899',
                'address' => 'الخرطوم, الرياض',
                'gender' => 'ذكر',
                'birth_date' => '1988-11-30',
                'blood_type' => 'O-',
                'medical_history' => 'سكري نوع 2',
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
