<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\PullAppointmentsJob;
use Illuminate\Support\Facades\Log;

/**
 * Pulls appointments from different sources and stores it to the database
 */
class PullAppointmentsCommand extends Command
{

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls appointments from different sources and stores it to the database';

    /**
     * PullAppointmentsCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appointmentServices = config('appointment.services');

        foreach ($appointmentServices as $appointmentService) {
            try {
                $this->dispatch(new PullAppointmentsJob(new $appointmentService));
            } catch (\Exception $e) {
                $exceptionMessage = $e->getMessage();
                Log::debug($exceptionMessage);
                continue;
            }
        }
    }
}
