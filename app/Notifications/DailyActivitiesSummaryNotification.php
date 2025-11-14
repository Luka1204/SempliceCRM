<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailyActivitiesSummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $activities
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('📅 Your Daily Activities Summary - ' . now()->format('M j, Y'))
            ->greeting('Good morning ' . $notifiable->name . '!')
            ->line('Here are your scheduled activities for today:');

        foreach ($this->activities as $activity) {
            $time = $activity->scheduled_at->format('g:i A');
            $mail->line("**{$time}** - {$activity->title} ({$activity->type_name}) - {$activity->company->name}");
        }

        $mail->action('View All Activities', route('activities.index'))
            ->line('Have a productive day!');

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'activity_count' => $this->activities->count(),
            'message' => 'You have ' . $this->activities->count() . ' activities scheduled for today.',
            'url' => route('activities.index'),
        ];
    }
}