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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('person_name');
            $table->string('person_gender');
            $table->string('person_email');
            $table->string('person_telp');
            $table->string('person_company');
            $table->string('activity_type');
            $table->string('activity_name');
            $table->text('short_desc');
            $table->string('payment_img');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
