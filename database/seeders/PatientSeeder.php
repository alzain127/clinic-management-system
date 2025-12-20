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
                'phone' => '0501234567',
                'address' => 'الرياض، حي المرسلات',
                'gender' => 'ذكر',
                'birth_date' => '1990-05-15',
                'blood_type' => 'O+',
                'medical_history' => 'لا يوجد أمراض مزمنة',
            ],
            [
                'name' => 'فاطمة عبدالله',
                'phone' => '0509876543',
                'address' => 'جدة، حي الزهراء',
                'gender' => 'أنثى',
                'birth_date' => '1985-08-20',
                'blood_type' => 'A+',
                'medical_history' => 'ضغط دم مرتفع',
            ],
            [
                'name' => 'خالد سعيد',
                'phone' => '0551112233',
                'address' => 'الدمام، حي الفنار',
                'gender' => 'ذكر',
                'birth_date' => '2000-12-10',
                'blood_type' => 'B+',
                'medical_history' => null,
            ],
            [
                'name' => 'نورة إبراهيم',
                'phone' => '0554445566',
                'address' => 'الرياض، حي النرجس',
                'gender' => 'أنثى',
                'birth_date' => '1995-03-25',
                'blood_type' => 'AB+',
                'medical_history' => 'حساسية من البنسلين',
            ],
            [
                'name' => 'عمر حسن',
                'phone' => '0507778899',
                'address' => 'مكة، حي العزيزية',
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
