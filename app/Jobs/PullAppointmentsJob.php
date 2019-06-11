<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Interfaces\AppointmentServiceInterface;
use App\Interfaces\AppointmentRepositoryInterface;

class PullAppointmentsJob extends Job implements ShouldQueue
{
    use InteractsWithQueue,
        SerializesModels;

    /**
     * Appointment Service
     * 
     * @var AppointmentServiceInterface
     */
    private $appointmentService;

    /**
     * PullAppointmentsJob constructor.
     * @param AppointmentServiceInterface $appointmentService
     */
    public function __construct(
        AppointmentServiceInterface $appointmentService
    ) {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Execute the job.
     * 
     * @param AppointmentRepositoryInterface $appointmentRepository
     * @return void
     */
    public function handle(AppointmentRepositoryInterface $appointmentRepository)
    {
        $appointments = $this->appointmentService->getAppointments();
        $appointmentRepository->storeAppointments($appointments);
    }
}
