<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->string('admin_level')->nullable(); // super_admin, admin
            $table->timestamp('admin_created_at')->nullable();
            $table->unsignedBigInteger('created_by_admin_id')->nullable();
            $table->foreign('created_by_admin_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by_admin_id']);
            $table->dropColumn(['is_admin', 'admin_level', 'admin_created_at', 'created_by_admin_id']);
        });
    }
};
