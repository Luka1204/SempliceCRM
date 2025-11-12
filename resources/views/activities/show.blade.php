<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $activity->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Activity details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('activities.edit', $activity) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                            onclick="return confirm('Are you sure you want to delete this activity? This action cannot be undone.')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
                <a href="{{ route('activities.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Back to Activities
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <!-- Left Column - Activity Details -->
                        <div class="md:col-span-2">
                            <!-- Activity Information Card -->
                            <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Activity Information</h3>
                                </div>
                                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $activity->type === 'call' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $activity->type === 'meeting' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $activity->type === 'email' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    {{ $activity->type === 'task' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $activity->type === 'note' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                    {{ $activity->type_name }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $activity->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $activity->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $activity->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $activity->status_name }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Scheduled For</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if($activity->scheduled_at)
                                                    {{ $activity->scheduled_at->format('M j, Y g:i A') }}
                                                    @if($activity->is_overdue)
                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                            Overdue
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400">Not scheduled</span>
                                                @endif
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Completed On</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if($activity->completed_at)
                                                    {{ $activity->completed_at->format('M j, Y g:i A') }}
                                                @else
                                                    <span class="text-gray-400">Not completed</span>
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if($activity->description)
                                                    <div class="prose prose-sm max-w-none">
                                                        <p class="whitespace-pre-line">{{ $activity->description }}</p>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">No description provided</span>
                                                @endif
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <!-- Related Entities Card -->
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Related Entities</h3>
                                </div>
                                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Company</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                <a href="{{ route('companies.show', $activity->company) }}" 
                                                   class="text-blue-600 hover:text-blue-900 font-medium">
                                                    {{ $activity->company->name }}
                                                </a>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if($activity->contact)
                                                    <a href="{{ route('contacts.show', $activity->contact) }}" 
                                                       class="text-green-600 hover:text-green-900 font-medium">
                                                        {{ $activity->contact->full_name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">No contact associated</span>
                                                @endif
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Meta Info & Actions -->
                        <div class="space-y-6">
                            <!-- Quick Actions -->
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Actions</h3>
                                </div>
                                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                                    <div class="space-y-3">
                                        @if($activity->status === 'scheduled')
                                        <form action="{{ route('activities.complete', $activity) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Mark as Completed
                                            </button>
                                        </form>
                                        @endif

                                        <a href="{{ route('activities.create', ['company_id' => $activity->company_id, 'contact_id' => $activity->contact_id]) }}" 
                                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            New Activity with Same Contact
                                        </a>

                                        <a href="{{ route('companies.show', $activity->company) }}" 
                                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                            View Company Details
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Information -->
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Meta Information</h3>
                                </div>
                                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                                    <dl class="space-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $activity->created_at->format('M j, Y \\a\\t g:i A') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $activity->updated_at->format('M j, Y \\a\\t g:i A') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Activity ID</dt>
                                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $activity->id }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>