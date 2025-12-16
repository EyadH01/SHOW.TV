<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Activity Information
            $table->string('activity_type'); // login, logout, register, profile_update, password_change, etc.
            $table->string('action'); // performed action
            $table->string('resource_type')->nullable(); // profile, show, episode, etc.
            $table->unsignedBigInteger('resource_id')->nullable(); // ID of the resource affected
            
            // Context Information
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('browser_name')->nullable();
            $table->string('os_name')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            
            // Additional Details
            $table->json('metadata')->nullable(); // Additional context data
            $table->enum('status', ['success', 'failed', 'pending'])->default('success');
            $table->text('description')->nullable();
            $table->timestamp('created_at');
            
            // Indexes for efficient querying
            $table->index(['user_id', 'activity_type']);
            $table->index(['user_id', 'created_at']);
            $table->index(['activity_type', 'created_at']);
            $table->index(['ip_address']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_activity_logs');
    }
}
