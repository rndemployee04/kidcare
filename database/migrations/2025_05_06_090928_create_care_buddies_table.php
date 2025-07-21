<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('care_buddies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();

            // CareBuddy category
            $table->enum('category', ['newlywed', 'professional', 'parent', 'senior'])->index();

            // Documents based on category
            $table->string('marriage_certificate_path')->nullable(); // For newlyweds/parents
            $table->string('certificate_path')->nullable();          // For professionals
            $table->string('child_birth_certificate_path')->nullable(); // For parents
            $table->string('birth_certificate_path')->nullable();    // For seniors

            // Identity Verification
            $table->string('id_proof_path');     // Required
            $table->string('selfie_path');       // Required
            $table->boolean('background_check_consent')->default(false);

            // Personal Info
            $table->string('phone');
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->string('profile_photo')->nullable();

            // Address Info
            $table->string('permanent_address');
            $table->string('current_address');
            $table->string('city')->index();
            $table->string('state');
            $table->string('zip');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Preferences
            $table->enum('service_radius', ['2-3', '3-4', '4-5']);
            $table->enum('child_age_limit', ['2-3', '3-5', '5-8', '8-10', 'all']);
            $table->json('availability')->nullable(); // morning, afternoon, full-day, etc.
            // $table->json('availability')->default(json_encode(['full_day'])); // morning, afternoon, full-day, etc.

            $table->boolean('willing_to_take_insurance')->default(false);
            $table->boolean('terms_accepted')->default(false);

            // Status
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('care_buddies');
    }
};
