<?php

namespace App\Services\Appointment;

use GuzzleHttp\Client as GuzzleHttpClient;
use Carbon\Carbon;
use App\Models\AppointmentModel;

class GerholdPLCAppointmentService extends AppointmentService
{
    /**
     * Gets appointments as array of AppointmentModel
     *
     * @return AppointmentModel[]
     */
    public function getAppointments()
    {
        $allAppointments = $this->getAllAppointmentsFromAPI();

        return $this->filterAppointments($allAppointments);
    }

    /**
     * Gets all appointments from Gerhold PLC API
     *
     * @return array
     */
    private function getAllAppointmentsFromAPI()
    {
        $client = new GuzzleHttpClient();
        $endpoint = env('API_URL') . '/xml';
        $dateFrom = Carbon::now()->format('Y-m-d H:i:s');
        $requestOptions = [
            'auth' =>  [
                env('GERHOLD_PLC_USERNAME'),
                env('GERHOLD_PLC_PASSWORD')
            ],
            'query' => [
                'from' => $dateFrom
            ]
        ];

        $response = $client->request('GET', $endpoint, $requestOptions);
        $responseContents = $response->getBody()->getContents();

        return simplexml_load_string($responseContents);
    }

    /**
     * Filters and returns appointments as array of AppointmentModel
     *
     * @param \SimpleXMLElement $appointmentsXml
     * @return AppointmentModel[]
     */
    private function filterAppointments($appointmentsXml)
    {
        $appointments = [];
        if (isset($appointmentsXml->appointment)) {
            foreach ($appointmentsXml->appointment as $appointment) {
                $startDateTime = Carbon::parse($appointment->start_date . ' ' . $appointment->start_time);
                $dateOfBirth = Carbon::parse($appointment->patient->date_of_birth);
                if (
                    $startDateTime->lessThanOrEqualTo(Carbon::now()->addMonth()) &&
                    $dateOfBirth->greaterThan(Carbon::today()->addYear(-18))
                ) {
                    $currentAppointment = new AppointmentModel();
                    $currentAppointment->dateTime = $startDateTime;
                    $currentAppointment->clinic = (string)$appointment->clinic->name;
                    $currentAppointment->patientName = (string)$appointment->patient->name;
                    $currentAppointment->patientGender = $this->getGender((int)$appointment->patient->sex);
                    $currentAppointment->patientDateOfBirth = $dateOfBirth;
                    $currentAppointment->doctorName = (string)$appointment->doctor->name;
                    $currentAppointment->specialty = (string)$appointment->specialty->name;

                    $appointments[] = $currentAppointment;
                }
            }
        }

        return $appointments;
    }

    /**
     * Resolves gender for the specified gender number
     *
     * @param integer $genderNumber
     * @return string
     */
    private function getGender(int $genderNumber)
    {
        return $genderNumber == '1' ? 'male' : 'female';
    }
}
