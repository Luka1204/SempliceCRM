<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notification Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('profile.notifications.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Email Notifications -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Email Notifications</h3>
                                    <p class="text-sm text-gray-600">Receive notifications via email</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="email_notifications" class="sr-only peer" 
                                           {{ old('email_notifications', auth()->user()->email_notifications) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <!-- Activity Reminders -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Activity Reminders</h3>
                                    <p class="text-sm text-gray-600">Get reminders for upcoming activities</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="activity_reminders" class="sr-only peer"
                                           {{ old('activity_reminders', auth()->user()->activity_reminders) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <!-- Reminder Time -->
                            <div>
                                <label for="reminder_hours_before" class="block text-sm font-medium text-gray-700">
                                    Reminder Time
                                </label>
                                <select name="reminder_hours_before" id="reminder_hours_before" 
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="1" {{ auth()->user()->reminder_hours_before == 1 ? 'selected' : '' }}>1 hour before</option>
                                    <option value="2" {{ auth()->user()->reminder_hours_before == 2 ? 'selected' : '' }}>2 hours before</option>
                                    <option value="6" {{ auth()->user()->reminder_hours_before == 6 ? 'selected' : '' }}>6 hours before</option>
                                    <option value="12" {{ auth()->user()->reminder_hours_before == 12 ? 'selected' : '' }}>12 hours before</option>
                                    <option value="24" {{ auth()->user()->reminder_hours_before == 24 ? 'selected' : '' }}>24 hours before</option>
                                    <option value="48" {{ auth()->user()->reminder_hours_before == 48 ? 'selected' : '' }}>48 hours before</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">When should we send reminders before activities?</p>
                            </div>

                            <!-- Notification Types -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Types</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="notification_types[]" value="upcoming_activities" 
                                               id="upcoming_activities" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                               {{ in_array('upcoming_activities', old('notification_types', auth()->user()->notification_preferences ?? [])) ? 'checked' : '' }}>
                                        <label for="upcoming_activities" class="ml-3 block text-sm font-medium text-gray-700">
                                            Upcoming Activities
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="notification_types[]" value="daily_summary" 
                                               id="daily_summary" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                               {{ in_array('daily_summary', old('notification_types', auth()->user()->notification_preferences ?? [])) ? 'checked' : '' }}>
                                        <label for="daily_summary" class="ml-3 block text-sm font-medium text-gray-700">
                                            Daily Summary
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="notification_types[]" value="overdue_activities" 
                                               id="overdue_activities" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                               {{ in_array('overdue_activities', old('notification_types', auth()->user()->notification_preferences ?? [])) ? 'checked' : '' }}>
                                        <label for="overdue_activities" class="ml-3 block text-sm font-medium text-gray-700">
                                            Overdue Activities
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Test Notifications -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Test Notifications</h3>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-600">Send test notifications to verify your settings:</p>
                        
                        <div class="flex space-x-4">
                            <form method="POST" action="{{ route('profile.notifications.test') }}">
                                @csrf
                                <input type="hidden" name="type" value="upcoming_activity">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 transition ease-in-out duration-150">
                                    Test Activity Reminder
                                </button>
                            </form>

                            <form method="POST" action="{{ route('profile.notifications.test') }}">
                                @csrf
                                <input type="hidden" name="type" value="daily_summary">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring ring-purple-300 transition ease-in-out duration-150">
                                    Test Daily Summary
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>