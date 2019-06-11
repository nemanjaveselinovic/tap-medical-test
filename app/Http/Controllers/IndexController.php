<?php

namespace App\Http\Controllers;

use App\Interfaces\AppointmentRepositoryInterface;
use Carbon\Carbon;
use App\Http\Requests\GetAppointmentsRequest;

class IndexController extends Controller
{
    /**
     * Appointment repository
     *
     * @var AppointmentRepositoryInterface
     */
    private $appointmentRepository;

    /**
     * ApiController constructor
     *
     * @param AppointmentRepositoryInterface $appointmentRepository
     */
    public function __construct(
        AppointmentRepositoryInterface $appointmentRepository
    ) {
        $this->appointmentRepository = $appointmentRepository;
    }

    /**
     * Shows home page
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $doctors = $this->appointmentRepository->getDoctors();
        $selectedDate = Carbon::today()->format('m/d/Y');

        return view('index', compact('doctors', 'selectedDate'));
    }

    /**
     * Shows home page with appointments
     *
     * @param GetAppointmentsRequest $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function getAppointments(GetAppointmentsRequest $request)
    {
        $selectedDoctor = $request->get('doctor');
        $selectedDate = $request->get('appointments_date');

        $doctors = $this->appointmentRepository->getDoctors();
        $appointments = $this->appointmentRepository->getAppointments($selectedDoctor, $selectedDate);

        return view('index', compact('doctors', 'selectedDoctor', 'selectedDate', 'appointments'));
    }
}
