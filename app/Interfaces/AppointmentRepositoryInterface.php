<?php

namespace App\Interfaces;

interface AppointmentRepositoryInterface
{
    /**
     * Returns appointment matched by column value
     *
     * @param string $column
     * @param mixed $value
     * @return \App\Appointment|null Appointment
     */
    public function fetchBy(string $column, $value);

    /**
     * Returns appointment matched by multiple column values
     *
     * @param array $params column value pairs
     * @return \App\Appointment|null Appointment
     */
    public function fetchByMultipleFields($params);

    /**
     * Stores appointments in the database
     *
     * @param AppointmentModel[] $appointments
     * @return \App\Appointment Appointment
     */
    public function storeAppointments($appointments);

    /**
     * Gets doctors
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getDoctors();

    /**
     * Gets appointments for the specified doctor and appointment date
     *
     * @param string $doctor
     * @param string $appointmentDate
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAppointments($doctor, $appointmentDate);
}
