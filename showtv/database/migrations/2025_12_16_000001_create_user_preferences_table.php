<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // UI/UX Preferences
            $table->string('theme')->default('light'); // light, dark, auto
            $table->string('accent_color')->default('blue');
            $table->string('font_size')->default('medium'); // small, medium, large
            $table->boolean('compact_view')->default(false);
            $table->boolean('show_welcome_tips')->default(true);
            
            // Content Preferences
            $table->json('favorite_genres')->nullable();
            $table->json('preferred_languages')->nullable();
            $table->integer('episodes_per_page')->default(10);
            $table->string('video_quality')->default('auto'); // low, medium, high, auto
            
            // Notification Preferences
            $table->boolean('new_episode_notifications')->default(true);
            $table->boolean('weekly_digest')->default(true);
            $table->boolean('marketing_emails')->default(false);
            $table->boolean('account_updates')->default(true);
            $table->boolean('security_alerts')->default(true);
            
            // Privacy Preferences
            $table->boolean('profile_visibility')->default(true); // true = public, false = private
            $table->boolean('show_activity')->default(true);
            $table->boolean('allow_friend_requests')->default(true);
            $table->boolean('show_online_status')->default(true);
            
            // Playback Preferences
            $table->boolean('autoplay_next_episode')->default(false);
            $table->boolean('autoplay_with_sound')->default(false);
            $table->string('default_subtitle_language')->nullable();
            $table->boolean('skip_intro')->default(false);
            
            // Accessibility Preferences
            $table->boolean('high_contrast')->default(false);
            $table->boolean('large_text')->default(false);
            $table->boolean('reduced_motion')->default(false);
            $table->boolean('screen_reader_mode')->default(false);
            
            $table->timestamps();
            
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_preferences');
    }
}
