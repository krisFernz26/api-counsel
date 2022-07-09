<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_status_id');
            $table->foreign('appointment_status_id')->references('id')->on('appointment_statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('counselor_id');
            $table->foreign('counselor_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('link');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
