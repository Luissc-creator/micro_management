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
        Schema::disableForeignKeyConstraints();
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('client_id'); // Foreign key to clients table
            $table->json('operator_ids')->nullable(); // Store assigned operator IDs
            $table->json('notification_setting_ids')->nullable(); // Store operator IDs
            $table->date('deadline')->nullable();
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->enum('project_status', [
                'not_started',      // Project has not started yet
                'in_progress',      // Project is currently being worked on
                'pending_client',   // Waiting for client input or approval
                'blocked',          // Project is halted due to external issues (e.g., client delay)
                'on_hold',          // Project is paused intentionally, but will resume
                'completed',        // Project is completed and approved
                'closed',           // Project is closed and no further work is expected
                'cancelled',        // Project is cancelled and will not proceed
                'overdue',          // Project has exceeded the original deadline
            ])->default('not_started');
            $table->timestamp('request_sent_at');
            $table->timestamp('blocked_at')->nullable();
            $table->integer('blocked_days')->default(0);

            $table->timestamps();
            // Foreign key constraints
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
