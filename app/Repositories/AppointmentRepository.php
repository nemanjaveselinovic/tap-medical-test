<?php

namespace App\Repositories;

use App\Appointment;
use App\Interfaces\AppointmentRepositoryInterface;
use App\Models\AppointmentModel;
use Carbon\Carbon;

class AppointmentRepository implements AppointmentRepositoryInterface
{
  /**
   * Appointment
   *
   * @var Appointment
   */
  protected $appointment;

  /**
   * AppointmentRepository constructor
   *
   * @param Appointment $appointment
   */
  public function __construct(
    Appointment $appointment
  ) {
    $this->appointment  = $appointment;
  }

  /**
   * Returns Appointment matched by column value
   *
   * @param string $column
   * @param mixed $value
   * @return \App\Appointment|null Appointment
   */
  public function fetchBy(string $column, $value)
  {
    return $this->appointment->where($column, $value)->first();
  }

  /**
   * Returns Appointment matched by multiple column values
   *
   * @param array $params column value pairs
   * @return \App\Appointment|null Appointment
   */
  public function fetchByMultipleFields($params)
  {
    $query = $this->appointment;

    foreach ($params as $column => $value) {
      $query = $query->where($column, $value);
    }

    return $query->first();
  }

  /**
   * Stores appointments in the database
   *
   * @param AppointmentModel[] $appointments
   * @return \App\Appointment Appointment
   */
  public function storeAppointments($appointments)
  {
    $storedAppointments = [];
    if (isset($appointments) && is_array($appointments)) {

      /** @var AppointmentModel $appointment */
      foreach ($appointments as $appointment) {

        /** @var Appointment $storedAppointment */
        $storedAppointment = $this->appointment->firstOrCreate([
          'clinic' => $appointment->clinic,
          'doctor_name' => $appointment->doctorName,
          'specialty' => $appointment->specialty,
          'patient_name' => $appointment->patientName,
          'patient_gender' => $appointment->patientGender,
          'patient_date_of_birth' => $appointment->patientDateOfBirth,
          'appointment_at' => $appointment->dateTime
        ]);

        $storedAppointments[] = $storedAppointment;
      }
    }

    return $storedAppointments;
  }

  /**
   * Gets doctors
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getDoctors()
  {
    $doctors = $this->appointment
      ->select('doctor_name')
      ->groupBy('doctor_name')
      ->get();

    return $doctors;
  }

  /**
   * Gets appointments for the specified doctor and appointment date
   *
   * @param string $doctor
   * @param string $appointmentDate
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getAppointments($doctor, $appointmentDate)
  {
    $appointments = $this->appointment
      ->where('doctor_name', '=', $doctor)
      ->whereDate('appointment_at', '=', Carbon::parse($appointmentDate)->toDateString())
      ->get();

    return $appointments;
  }
}
