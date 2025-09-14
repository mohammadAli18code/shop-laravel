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
            $table->bigIncrements('id')->unsigned()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('age')->unsigned();
            $table->enum('gender' , ['male' , 'female' , 'unspecified'])->default('unspecified');
            $table->string('phone_number' , 20)->unique();
            $table->string('email')->unique();
            $table->enum('is_active' , [1 , 2]);
            $table->enum('enum' , ['customer' , 'admin' , 'author' , 'manager']);
            $table->string('country');
            $table->string('city');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('verify_token')->nullable();
            $table->text('forgot_token')->nullable();
            $table->text('forgot_token_expire')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
