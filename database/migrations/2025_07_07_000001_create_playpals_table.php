<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('playpals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('category')->nullable();
            $table->string('id_proof_path')->nullable();
            $table->string('selfie_path')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('current_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('service_radius')->nullable();
            $table->string('child_age_limit')->nullable();
            $table->boolean('willing_to_take_insurance')->default(false);
            $table->boolean('background_check_consent')->default(false);
            $table->boolean('terms_accepted')->default(false);
            $table->json('availability')->nullable();
            $table->string('certificate_path')->nullable();
            $table->string('marriage_certificate_path')->nullable();
            $table->string('birth_certificate_path')->nullable();
            $table->string('child_birth_certificate_path')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('playpals');
    }
};
