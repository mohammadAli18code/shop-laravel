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
        Schema::create('addresses', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        $table->string('title')->nullable(); // مثل "خانه"، "محل کار"
        $table->string('recipient_name');   // اسم گیرنده
        $table->string('phone');            // شماره تماس گیرنده
        $table->string('postal_code')->nullable();
        
        $table->string('province');         // استان
        $table->string('city');             // شهر
        $table->string('address_line');     // متن کامل آدرس
        $table->string('building_number')->nullable();
        $table->string('unit_number')->nullable();

        $table->boolean('is_default')->default(false); // آدرس پیش‌فرض کاربر

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
