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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('mobile_phone')->unique();
            $table->string('username')->unique();
            $table->enum('job_role', ['registered_nurse', 'healthcare_assistant', 'support_worker']);
            $table->string('password');
            $table->string('profile_photo')->nullable();
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->string('postcode');
            $table->text('address');
            $table->string('country');
            $table->boolean('criminal_record')->default(false);
            $table->string('ni_number')->unique();
            $table->boolean('dbs_status')->default(false);
            $table->string('dbs_certificate')->nullable();
            $table->enum('nationality', ['UK', 'EU', 'Other']);
            $table->boolean('right_to_work')->default(false);
            $table->string('brp_number')->nullable();
            $table->string('brp_document')->nullable();
            $table->text('work_history')->nullable();
            $table->string('bank_sort_code')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('signature')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
