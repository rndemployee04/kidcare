<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('care_buddies', function (Blueprint $table) {
            $table->string('category')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('id_proof_path')->nullable()->change();
            $table->string('permanent_address')->nullable()->change();
            $table->string('current_address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('zip')->nullable()->change();
            $table->string('service_radius')->nullable()->change();
            $table->string('child_age_limit')->nullable()->change();
            $table->string('selfie_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('care_buddies', function (Blueprint $table) {
            $table->string('category')->nullable(false)->change();
            $table->date('dob')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            $table->string('id_proof_path')->nullable(false)->change();
            $table->string('permanent_address')->nullable(false)->change();
            $table->string('current_address')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->string('zip')->nullable(false)->change();
            $table->string('service_radius')->nullable(false)->change();
            $table->string('child_age_limit')->nullable(false)->change();
            $table->string('selfie_path')->nullable(false)->change();
        });
    }
};
