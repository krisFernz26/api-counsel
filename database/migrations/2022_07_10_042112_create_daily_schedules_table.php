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
        Schema::create('daily_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counselor_schedule_id');
            $table->foreign('counselor_schedule_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date')->nullable(); // only fill in if specific date
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_schedules');
    }
};
