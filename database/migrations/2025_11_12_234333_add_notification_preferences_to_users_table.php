<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('notification_preferences')->nullable()->after('remember_token');
            $table->boolean('email_notifications')->default(true)->after('notification_preferences');
            $table->boolean('activity_reminders')->default(true)->after('email_notifications');
            $table->integer('reminder_hours_before')->default(24)->after('activity_reminders');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notification_preferences',
                'email_notifications', 
                'activity_reminders',
                'reminder_hours_before'
            ]);
        });
    }
};