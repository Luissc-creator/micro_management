<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('task_name'); // Task name
            $table->text('task_description'); // Task description
            $table->enum('task_priority', ['low', 'medium', 'high']); // Priority
            $table->date('task_deadline'); // Task deadline
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade');; // Foreign key to the operator (assuming users table holds operator data)
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');; // Foreign key to the project
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}