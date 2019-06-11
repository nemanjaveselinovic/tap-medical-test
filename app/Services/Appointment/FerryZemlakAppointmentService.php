<?php

namespace App\Services\Appointment;

use GuzzleHttp\Client as GuzzleHttpClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\AppointmentModel;

class FerryZemlakAppointmentService extends AppointmentService
{
    /**
     * Token name stored in cache
     *
     * @var string
     */
    private $cacheTokenName = 'tokenFerryZemlak';

    /**
     * Token
     *
     * @var string
     */
    private $token;

    /**
     * Gets appointments as array of AppointmentModel
     *
     * @return AppointmentModel[]
     */
    public function getAppointments()
    {
        $this->token = $this->getAuthToken();
        $allAppointments = $this->getAllAppointmentsFromAPI();

        return $this->filterAppointments($allAppointments);
    }

    /**
     * Gets auth token from cache if exists otherwise gets token from auth API
     *
     * @return string
     */
    private function getAuthToken()
    {
        return $this->getAuthTokenFromApi();
        if (Cache::has($this->cacheTokenName)) {
            return Cache::get($this->cacheTokenName);
        } else {
            $token = $this->getAuthTokenFromApi();
            Cache::put($this->cacheTokenName, $token, now()->addMinutes(50));

            return $token;
        }
    }

    /**
     * Gets token from auth API
     *
     * @return string
     */
    private function getAuthTokenFromApi()
    {
        $client = new GuzzleHttpClient();
        $endpoint = env('API_URL') . '/auth';
        $requestOptions = [
            'json' =>  [
                "email" => env('FERRY_ZEMLAK_EMAIL'),
                "password" => env('FERRY_ZEMLAK_PASSWORD')
            ]
        ];
        $response = $client->request('POST', $endpoint, $requestOptions);
        $responseContents = $response->getBody()->getContents();

        return json_decode($responseContents)->token;
    }

    /**
     * Gets all appointments from Ferry-Zemlak API
     *
     * @return array
     */
    private function getAllAppointmentsFromAPI()
    {
        $allAppointments = [];
        $nextPage = 1;
        while ($nextPage) {
            $response = $this->getAllAppointmentsFromAPIPerPage($nextPage);
            $allAppointments = array_merge($allAppointments, $response->data);
            $nextPage = empty($response->next_page_url) ? 0 : $response->current_page + 1;
        }

        return $allAppointments;
    }

    /**
     * Gets all appointments for the specified page from Ferry-Zemlak API
     *
     * @param integer $page
     * @return array
     */
    private function getAllAppointmentsFromAPIPerPage($page)
    {
        $client = new GuzzleHttpClient();
        $endpoint = env('API_URL') . '/json';
        $requestOptions = [
            'headers' =>  [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept'        => 'application/json',
            ],
            'query' => [
                'page' => $page
            ]
        ];
        $response = $client->request('GET', $endpoint, $requestOptions);
        $responseContents = $response->getBody()->getContents();

        return json_decode($responseContents);
    }

    /**
     * Filters and returns appointments as array of AppointmentModel
     *
     * @param array $appointmentsXml
     * @return AppointmentModel[]
     */
    private function filterAppointments($allAppointments)
    {
        $appointments = [];
        if (isset($allAppointments)) {
            foreach ($allAppointments as $appointment) {
                $startDateTime = Carbon::parse($appointment->datetime);
                $dateOfBirth = Carbon::parse($appointment->patient->dob);
                if (
                    $startDateTime->lessThanOrEqualTo(Carbon::now()->addMonth()) &&
                    $dateOfBirth->greaterThan(Carbon::today()->addYear(-18)) &&
                    $appointment->status !== "cancelled"
                ) {
                    $currentAppointment = new AppointmentModel();
                    $currentAppointment->dateTime = $startDateTime;
                    $currentAppointment->clinic = $appointment->clinic->name;
                    $currentAppointment->patientName = $appointment->patient->name;
                    $currentAppointment->patientGender = $appointment->patient->gender;
                    $currentAppointment->patientDateOfBirth = $dateOfBirth;
                    $currentAppointment->doctorName = $appointment->doctor->name;
                    $currentAppointment->specialty = $appointment->specialty->name;

                    $appointments[] = $currentAppointment;
                }
            }
        }

        return $appointments;
    }
}
