<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Session Information
            $table->string('session_id')->unique();
            $table->string('device_name')->nullable(); // User-friendly device name
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('browser_name')->nullable();
            $table->string('os_name')->nullable();
            $table->string('browser_version')->nullable();
            
            // Location Information
            $table->string('ip_address', 45);
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('timezone')->nullable();
            
            // Session Details
            $table->text('user_agent');
            $table->timestamp('login_time');
            $table->timestamp('last_activity');
            $table->timestamp('logout_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('remember_token')->nullable();
            
            // Security Information
            $table->string('fingerprint')->nullable(); // Browser/device fingerprint
            $table->enum('status', ['active', 'expired', 'terminated', 'logged_out'])->default('active');
            $table->text('security_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes for efficient querying
            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'last_activity']);
            $table->index(['session_id']);
            $table->index(['ip_address']);
            $table->index(['status']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sessions');
    }
}
