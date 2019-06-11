<?php

namespace App\Services\Appointment;

use App\Interfaces\AppointmentServiceInterface;

abstract class AppointmentService implements AppointmentServiceInterface
{
    /**
     * Gets appointments as array of AppointmentModel
     *
     * @return AppointmentModel[]
     */
    public abstract function getAppointments();
}
