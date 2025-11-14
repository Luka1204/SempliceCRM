<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Activity;
use App\Notifications\UpcomingActivityNotification;
use App\Notifications\DailyActivitiesSummaryNotification;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function notifications()
{
    return view('profile.notifications');
}

public function updateNotifications(Request $request)
{
    $request->validate([
        'email_notifications' => 'boolean',
        'activity_reminders' => 'boolean',
        'reminder_hours_before' => 'integer|min:1|max:168',
        'notification_types' => 'array',
    ]);

    $user = $request->user();
    
    $user->update([
        'email_notifications' => $request->boolean('email_notifications'),
        'activity_reminders' => $request->boolean('activity_reminders'),
        'reminder_hours_before' => $request->reminder_hours_before,
        'notification_preferences' => $request->notification_types,
    ]);

    return redirect()->route('profile.notifications')
        ->with('success', 'Notification preferences updated successfully.');
}

public function testNotifications(Request $request)
{
    $user = $request->user();
    $type = $request->type;

    try {
        switch ($type) {
            case 'upcoming_activity':
                // Create a test activity
                $activity = Activity::factory()->create([
                    'user_id' => $user->id,
                    'title' => 'Test Activity - ' . now()->format('Y-m-d H:i'),
                    'type' => 'meeting',
                    'scheduled_at' => now()->addHour(),
                    'status' => 'scheduled',
                ]);
                
                $user->notify(new UpcomingActivityNotification($activity));
                break;

            case 'daily_summary':
                $activities = Activity::factory()->count(3)->create([
                    'user_id' => $user->id,
                    'status' => 'scheduled',
                    'scheduled_at' => now()->addDay(),
                ]);
                
                $user->notify(new DailyActivitiesSummaryNotification($activities));
                break;
        }

        return redirect()->route('profile.notifications')
            ->with('success', 'Test notification sent successfully! Check your email and notifications.');

    } catch (\Exception $e) {
        return redirect()->route('profile.notifications')
            ->with('error', 'Failed to send test notification: ' . $e->getMessage());
    }
}
}
