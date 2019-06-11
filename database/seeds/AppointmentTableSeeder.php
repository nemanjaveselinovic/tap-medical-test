<?php

use Illuminate\Database\Seeder;
use App\Appointment;

class AppointmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Appointment::create([
            'id' => 1,
            'clinic' => 'Ferry-Zemlak',
            'doctor_name' => 'Ms. Lottie Reynolds IV',
            'specialty' => 'Plastic Surgery',
            'patient_name' => 'Noah Rempel MD',
            'patient_gender' => 'male',
            'patient_date_of_birth' => '2010-02-24',
            'appointment_at' => '2019-06-11 09:00:00',
            'created_at' => '2019-06-11 13:33:02',
            'updated_at' => '2019-06-11 13:33:09'
        ]);

        Appointment::create([
            'id' => 2,
            'clinic' => 'Ferry-Zemlak',
            'doctor_name' => 'Serenity Gerhold',
            'specialty' => 'Dentistry',
            'patient_name' => 'Cathrine Larkin',
            'patient_gender' => 'female',
            'patient_date_of_birth' => '2012-05-20',
            'appointment_at' => '2019-06-11 12:00:00',
            'created_at' => '2019-06-11 13:34:02',
            'updated_at' => '2019-06-11 13:34:09'
        ]);

        Appointment::create([
            'id' => 3,
            'clinic' => 'Gerhold PLC',
            'doctor_name' => 'Ms. Mayra Torphy V',
            'specialty' => 'Dentistry',
            'patient_name' => 'Mr. Dock Collins Sr.',
            'patient_gender' => 'male',
            'patient_date_of_birth' => '2001-07-21',
            'appointment_at' => '2019-06-11 14:30:00',
            'created_at' => '2019-06-11 13:35:02',
            'updated_at' => '2019-06-11 13:35:09'
        ]);

        Appointment::create([
            'id' => 4,
            'clinic' => 'Gerhold PLC',
            'doctor_name' => 'Mrs. Josiane Hirthe III',
            'specialty' => 'CT Scan',
            'patient_name' => 'Ashlynn Rosenbaum',
            'patient_gender' => 'female',
            'patient_date_of_birth' => '2002-08-06',
            'appointment_at' => '2019-06-11 17:45:00',
            'created_at' => '2019-06-11 13:36:02',
            'updated_at' => '2019-06-11 13:36:09'
        ]);
    }
}
