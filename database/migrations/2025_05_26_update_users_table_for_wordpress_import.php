<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Make fields optional for WordPress import
            $table->string('mobile_number')->nullable()->change();
            $table->string('username')->nullable()->change();
            $table->enum('job_role', ['Registered Nurse', 'Healthcare Assistant', 'Support Worker', 'Senior Care Assistant'])->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->enum('gender', ['male', 'female'])->nullable()->change();
            $table->string('national_insurance_number')->nullable()->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert changes (note: this might cause issues if data is missing)
            $table->string('mobile_number')->nullable(false)->change();
            $table->string('username')->nullable(false)->change();
            $table->enum('job_role', ['Registered Nurse', 'Healthcare Assistant', 'Support Worker', 'Senior Care Assistant'])->nullable(false)->change();
            $table->date('date_of_birth')->nullable(false)->change();
            $table->enum('gender', ['male', 'female'])->nullable(false)->change();
            $table->string('national_insurance_number')->nullable(false)->change();
        });
    }
};
