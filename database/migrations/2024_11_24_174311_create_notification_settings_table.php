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
        // Create Notification Settings Table
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // e.g., task_completed, deadline_missed
            $table->text('email_recipients'); // Comma-separated list of emails
            $table->string('frequency'); // e.g., hourly, daily, weekly
            $table->unsignedBigInteger('project_id'); //Assuming project_id is an unsigned big integer.  Adjust accordingly.
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade'); // Or onDelete('set null')
            $table->string('custom_subject'); // Custom email subject
            $table->text('custom_message'); // Custom email message
            $table->boolean('status')->default(true); // Active/Inactive flag
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
