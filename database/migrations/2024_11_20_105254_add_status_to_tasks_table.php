<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', [
                'not_started',          // Task has been created but not worked on yet
                'in_progress',          // Task is currently being worked on by the operator
                'under_review',         // Task is completed by the operator and is under client or admin review
                'completed',            // Task is completed and approved by the client or admin
                'cancelled',            // Task has been cancelled and will not be worked on
                'overdue',              // Task has passed its deadline without being completed
                'pending_client',
                'paused'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
