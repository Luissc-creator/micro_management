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
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->default(null); // Related task if any
            $table->unsignedBigInteger('client_id'); // Client receiving the request
            $table->unsignedBigInteger('operator_id'); // Operator creating the request
            $table->text('message'); // The content of the request
            $table->enum('status', ['pending', 'completed', 'blocked'])->default('pending'); // Status of the request
            $table->timestamp('response_received_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('client_id')->default(null)->references('id')->on('users')->onDelete('cascade');
            $table->foreign('operator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_requests');
    }
};
