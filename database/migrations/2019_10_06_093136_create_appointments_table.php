<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $table = 'appointments';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->table)) return;
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('clinic');
            $table->string('doctor_name');
            $table->string('specialty');
            $table->string('patient_name');
            $table->enum('patient_gender', ['male', 'female']);
            $table->date('patient_date_of_birth');
            $table->dateTime('appointment_at');
            $table->timestamps();
            $table->unique(['clinic', 'doctor_name', 'appointment_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
