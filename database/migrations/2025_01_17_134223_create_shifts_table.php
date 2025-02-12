<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('location');
            $table->string('department');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled']);
            $table->dateTime('checkin_time')->nullable();
            $table->dateTime('checkout_time')->nullable();
            $table->json('last_tracked_location')->nullable();
            $table->decimal('rate_per_hour', 8, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shifts');
    }
};