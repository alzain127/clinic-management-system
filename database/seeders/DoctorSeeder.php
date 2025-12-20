<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'د. محمد الأحمد',
                'phone' => '0961234567',
                'specialization' => 'طب عام',
                'duty_schedule' => [
                    'الأحد' => '09:00-17:00',
                    'الاثنين' => '09:00-17:00',
                    'الثلاثاء' => '09:00-17:00',
                    'الأربعاء' => '09:00-17:00',
                    'الخميس' => '09:00-13:00',
                ],
            ],
            [
                'name' => 'د. سارة الجعلي',
                'phone' => '0969876543',
                'specialization' => 'طب الأطفال',
                'duty_schedule' => [
                    'الأحد' => '10:00-16:00',
                    'الاثنين' => '10:00-16:00',
                    'الثلاثاء' => '10:00-16:00',
                    'الأربعاء' => '10:00-16:00',
                ],
            ],
            [
                'name' => 'د. عبدالله محمد',
                'phone' => '0951112244',
                'specialization' => 'طب الأسنان',
                'duty_schedule' => [
                    'الأحد' => '15:00-21:00',
                    'الثلاثاء' => '15:00-21:00',
                    'الخميس' => '15:00-21:00',
                ],
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}
