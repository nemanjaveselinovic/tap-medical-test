<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * App\Appointment
 *
 * @property integer $id 
 * @property string $clinic
 * @property string $doctor_name
 * @property string $specialty
 * @property string $patient_name
 * @property string $patient_gender
 * @property \Carbon\Carbon $patient_date_of_birth
 * @property \Carbon\Carbon $appointment_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereClinic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereDoctorName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereSpecialty($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment wherePatientName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment wherePatientGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment wherePatientDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereAppointmentAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Appointment whereUpdatedAt($value)
 */
class Appointment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'appointments';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'patient_date_of_birth'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'clinic',
        'doctor_name',
        'specialty',
        'patient_name',
        'patient_gender',
        'patient_date_of_birth',
        'appointment_at'
    ];

    /**
     * Adds appointment time attribute to the model.
     *
     * @return string
     */
    public function getAppointmentTimeAttribute()
    {
        return Carbon::parse($this->appointment_at)->format('H:i:s');
    }

    /**
     * Adds state attribute to the model.
     *
     * @return string
     */
    public function getStateAttribute()
    {
        $appointmentDateTime = Carbon::parse($this->appointment_at);
        $state = $appointmentDateTime->greaterThan(Carbon::now()) ? 'upcoming' : 'passed';

        return $state;
    }
}
