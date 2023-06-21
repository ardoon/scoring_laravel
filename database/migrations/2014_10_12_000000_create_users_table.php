<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->timestamp('username_verified_at')->nullable();
            $table->string('password');

            // Additional Fields For This Project
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('nationalId');
            $table->string('fatherName');
            $table->string('wifeName')->nullable();
            $table->string('mobile');
            $table->string('address');
            $table->bigInteger('extraScore')->default(0);
            $table->json('properties');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
