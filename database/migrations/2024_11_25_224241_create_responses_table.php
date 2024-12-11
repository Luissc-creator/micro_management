<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_request_id')->constrained()->onDelete('cascade'); // Link to the request being responded to
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // The client who responded
            $table->text('message')->nullable(); // Client's response (text)
            $table->string('file_path')->nullable(); // If the client attaches a file
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
