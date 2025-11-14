<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\User;
use App\Notifications\UpcomingActivityNotification;
use App\Notifications\DailyActivitiesSummaryNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendActivityReminders extends Command
{
    protected $signature = 'crm:send-activity-reminders 
                           {--hours=24 : Number of hours before activity to send reminder}
                           {--summary : Send daily summary instead of individual reminders}';
    
    protected $description = 'Send reminders for upcoming activities';

    public function handle()
    {
        if ($this->option('summary')) {
            return $this->sendDailySummary();
        }

        return $this->sendIndividualReminders();
    }

    protected function sendIndividualReminders()
    {
        $hours = (int) $this->option('hours');
        $reminderTime = now()->addHours($hours);
        
        $activities = Activity::with(['company', 'contact', 'user'])
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', $reminderTime)
            ->whereDoesntHave('notifications', function ($query) use ($hours) {
                $query->where('type', UpcomingActivityNotification::class)
                      ->where('created_at', '>=', now()->subHours($hours / 2));
            })
            ->get();

        $this->info("Found {$activities->count()} activities to remind within {$hours} hours.");

        $notifiedCount = 0;

        foreach ($activities as $activity) {
            try {
                $activity->user->notify(new UpcomingActivityNotification($activity));
                $notifiedCount++;
                $this->info("Notified {$activity->user->name} about: {$activity->title}");
            } catch (\Exception $e) {
                $this->error("Failed to notify {$activity->user->name} about: {$activity->title}");
                Log::error('Activity reminder failed', [
                    'activity_id' => $activity->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Successfully sent {$notifiedCount} reminders.");
        return Command::SUCCESS;
    }

    protected function sendDailySummary()
    {
        $users = User::with(['activities' => function ($query) {
            $query->where('status', 'scheduled')
                  ->where('scheduled_at', '>=', now())
                  ->where('scheduled_at', '<=', now()->addDay())
                  ->with(['company', 'contact'])
                  ->orderBy('scheduled_at');
        }])->whereHas('activities', function ($query) {
            $query->where('status', 'scheduled')
                  ->where('scheduled_at', '>=', now())
                  ->where('scheduled_at', '<=', now()->addDay());
        })->get();

        $this->info("Sending daily summary to {$users->count()} users.");

        $notifiedCount = 0;

        foreach ($users as $user) {
            if ($user->activities->count() > 0) {
                try {
                    $user->notify(new DailyActivitiesSummaryNotification($user->activities));
                    $notifiedCount++;
                    $this->info("Sent daily summary to {$user->name} with {$user->activities->count()} activities.");
                } catch (\Exception $e) {
                    $this->error("Failed to send summary to {$user->name}");
                    Log::error('Daily summary failed', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $this->info("Successfully sent {$notifiedCount} daily summaries.");
        return Command::SUCCESS;
    }
}