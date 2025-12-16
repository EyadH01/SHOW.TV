<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Personal Information
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('image');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable()->after('date_of_birth');
            }

            // Location Information
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('country');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('city');
            }

            // Social Media and Website
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('website');
            }
            if (!Schema::hasColumn('users', 'twitter_url')) {
                $table->string('twitter_url')->nullable()->after('facebook_url');
            }
            if (!Schema::hasColumn('users', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('twitter_url');
            }
            if (!Schema::hasColumn('users', 'linkedin_url')) {
                $table->string('linkedin_url')->nullable()->after('instagram_url');
            }
            if (!Schema::hasColumn('users', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('linkedin_url');
            }

            // User Preferences and Settings
            if (!Schema::hasColumn('users', 'preferences')) {
                $table->json('preferences')->nullable()->after('youtube_url');
            }
            if (!Schema::hasColumn('users', 'language')) {
                $table->string('language', 10)->default('en')->after('preferences');
            }
            if (!Schema::hasColumn('users', 'email_notifications')) {
                $table->boolean('email_notifications')->default(true)->after('language');
            }
            if (!Schema::hasColumn('users', 'sms_notifications')) {
                $table->boolean('sms_notifications')->default(false)->after('email_notifications');
            }

            // Account Management
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('sms_notifications');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('last_login_at');
            }
            if (!Schema::hasColumn('users', 'terms_accepted')) {
                $table->boolean('terms_accepted')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('users', 'terms_accepted_at')) {
                $table->timestamp('terms_accepted_at')->nullable()->after('terms_accepted');
            }

            // Account Security
            if (!Schema::hasColumn('users', 'login_attempts')) {
                $table->integer('login_attempts')->default(0)->after('terms_accepted_at');
            }
            if (!Schema::hasColumn('users', 'locked_until')) {
                $table->timestamp('locked_until')->nullable()->after('login_attempts');
            }
            if (!Schema::hasColumn('users', 'two_factor_secret')) {
                $table->string('two_factor_secret')->nullable()->after('locked_until');
            }
            if (!Schema::hasColumn('users', 'two_factor_enabled')) {
                $table->boolean('two_factor_enabled')->default(false)->after('two_factor_secret');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'bio', 'date_of_birth', 'gender', 'country', 'city', 'address',
                'website', 'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url',
                'preferences', 'language', 'email_notifications', 'sms_notifications',
                'last_login_at', 'is_active', 'terms_accepted', 'terms_accepted_at',
                'login_attempts', 'locked_until', 'two_factor_secret', 'two_factor_enabled'
            ]);
        });
    }
}
