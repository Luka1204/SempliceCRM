<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpcomingActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Activity $activity
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $activityTime = $this->activity->scheduled_at->format('M j, Y \a\t g:i A');
        
        return (new MailMessage)
            ->subject('🔔 Upcoming Activity: ' . $this->activity->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have an upcoming activity scheduled:')
            ->line('**' . $this->activity->title . '**')
            ->line('**Type:** ' . $this->activity->type_name)
            ->line('**Scheduled for:** ' . $activityTime)
            ->line('**Company:** ' . $this->activity->company->name)
            ->when($this->activity->contact, function ($mail) {
                return $mail->line('**Contact:** ' . $this->activity->contact->full_name);
            })
            ->action('View Activity', route('activities.show', $this->activity))
            ->line('Thank you for using our CRM!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'activity_id' => $this->activity->id,
            'title' => $this->activity->title,
            'type' => $this->activity->type,
            'scheduled_at' => $this->activity->scheduled_at,
            'company_name' => $this->activity->company->name,
            'message' => 'Upcoming activity: ' . $this->activity->title . ' scheduled for ' . $this->activity->scheduled_at->format('M j, g:i A'),
            'url' => route('activities.show', $this->activity),
        ];
    }
}