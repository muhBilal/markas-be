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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('episode');
            $table->string('title');
            $table->string('sub_title');
            $table->text('description');
            $table->timestamp('event_date');
            $table->timestamp('start_time')->default(now());
            $table->timestamp('end_time')->default(now());
            $table->foreignId('event_role_id')->constrained('event_roles')->cascadeOnDelete();
            $table->foreignId('event_album_id')->constrained('event_albums')->cascadeOnDelete();
            $table->foreignId('regional_id')->constrained('regionals')->cascadeOnDelete();
            $table->string('speaker_name');
            $table->string('speaker_desc');
            $table->string('speaker_image');
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('activity_type_id')->constrained('activity_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
