<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('playpal_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playpal_id');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');
            $table->date('date');
            $table->string('time');
            $table->integer('duration_days');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->foreign('playpal_id')->references('id')->on('playpals')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('playpal_bookings');
    }
};
