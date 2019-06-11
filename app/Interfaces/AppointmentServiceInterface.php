<?php

namespace App\Interfaces;

interface AppointmentServiceInterface
{
    /**
     * Gets appointments as array of AppointmentModel
     *
     * @return AppointmentModel[]
     */
    public function getAppointments();
}
