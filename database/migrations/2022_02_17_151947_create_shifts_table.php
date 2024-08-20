<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('outlet_id');
            $table->integer('terminal_id');
            $table->date('business_date');
            $table->string('employee_number')->nullable();
            $table->integer('shift_count');
            $table->boolean('shift_posted')->default(0);
            $table->datetime('shift_posted_at')->nullable();

            $table->boolean('day_posted')->default(false);
            $table->datetime('day_posted_at')->nullable();
            $table->string('day_posted_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
