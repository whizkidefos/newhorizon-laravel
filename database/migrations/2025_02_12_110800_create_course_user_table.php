<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('enrolled'); // enrolled, in_progress, completed
            $table->string('payment_status')->default('pending'); // pending, paid, refunded
            $table->integer('progress')->default(0);
            $table->timestamps();
            
            $table->unique(['course_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_user');
    }
};
