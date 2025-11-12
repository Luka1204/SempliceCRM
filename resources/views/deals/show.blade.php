<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $deal->name }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Deal details and progress</p>
            </div>
            <div class="flex space-x-2">
                @if(!$deal->is_closed)
                <form action="{{ route('deals.mark-won', $deal) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150"
                            onclick="return confirm('Mark this deal as won? This action cannot be undone.')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Mark Won
                    </button>
                </form>
                <form action="{{ route('deals.mark-lost', $deal) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                            onclick="return confirm('Mark this deal as lost? This action cannot be undone.')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Mark Lost
                    </button>
                </form>
                @endif
                <a href="{{ route('deals.edit', $deal) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('deals.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Back to Deals
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Left Column - Deal Information -->
                <div class="lg:col-span-2">
                    <!-- Deal Details Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Deal Information</h3>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Stage</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $deal->stage === 'lead' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $deal->stage === 'qualification' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $deal->stage === 'proposal' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $deal->stage === 'negotiation' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $deal->stage === 'closed_won' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $deal->stage === 'closed_lost' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $deal->stage_name }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Amount</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">
                                        @if($deal->amount)
                                            ${{ number_format($deal->amount, 2) }}
                                        @else
                                            <span class="text-gray-400">Not specified</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Expected Close Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($deal->expected_close_date)
                                            {{ $deal->expected_close_date->format('M j, Y') }}
                                            @if($deal->expected_close_date->isPast() && !$deal->is_closed)
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    Overdue
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">Not set</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Closed Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($deal->closed_date)
                                            {{ $deal->closed_date->format('M j, Y') }}
                                        @else
                                            <span class="text-gray-400">Not closed</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card -->
                    @if($deal->description)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                            <div class="prose prose-sm max-w-none">
                                <p class="text-gray-700 whitespace-pre-line">{{ $deal->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Related Activities Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Related Activities</h3>
                                <a href="{{ route('activities.create', ['company_id' => $deal->company_id, 'contact_id' => $deal->contact_id]) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Activity
                                </a>
                            </div>
                            
                            @if($deal->activities->count() > 0)
                                <div class="space-y-3">
                                    @foreach($deal->activities->take(5) as $activity)
                                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full 
                                                {{ $activity->type === 'call' ? 'bg-blue-100' : '' }}
                                                {{ $activity->type === 'meeting' ? 'bg-green-100' : '' }}
                                                {{ $activity->type === 'email' ? 'bg-purple-100' : '' }}
                                                flex items-center justify-center">
                                                <svg class="w-4 h-4 
                                                    {{ $activity->type === 'call' ? 'text-blue-600' : '' }}
                                                    {{ $activity->type === 'meeting' ? 'text-green-600' : '' }}
                                                    {{ $activity->type === 'email' ? 'text-purple-600' : '' }}" 
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($activity->type === 'call')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                    @elseif($activity->type === 'meeting')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    @endif
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                                <p class="text-xs text-gray-500">{{ $activity->type_name }} • {{ $activity->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            {{ $activity->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $activity->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}">
                                            {{ $activity->status_name }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                                @if($deal->activities->count() > 5)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('activities.index') }}" class="text-sm text-blue-600 hover:text-blue-900">
                                        View all {{ $deal->activities->count() }} activities
                                    </a>
                                </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No activities yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Related Entities & Actions -->
                <div class="space-y-6">
                    <!-- Deal Summary Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Deal Summary</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Status</span>
                                    <span class="text-sm font-medium 
                                        {{ $deal->is_closed ? ($deal->is_won ? 'text-green-600' : 'text-red-600') : 'text-blue-600' }}">
                                        {{ $deal->is_closed ? ($deal->is_won ? 'Won' : 'Lost') : 'In Progress' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Created</span>
                                    <span class="text-sm text-gray-900">{{ $deal->created_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Last Updated</span>
                                    <span class="text-sm text-gray-900">{{ $deal->updated_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Deal ID</span>
                                    <span class="text-sm font-mono text-gray-900">#{{ $deal->id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company & Contact Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Related Entities</h3>
                            <div class="space-y-4">
                                <!-- Company -->
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $deal->company->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $deal->company->email ?? 'No email' }}</p>
                                    </div>
                                    <a href="{{ route('companies.show', $deal->company) }}" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>

                                <!-- Contact -->
                                @if($deal->contact)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 font-semibold text-sm">{{ $deal->contact->initials }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $deal->contact->full_name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $deal->contact->position ?? 'No position' }}</p>
                                    </div>
                                    <a href="{{ route('contacts.show', $deal->contact) }}" class="text-green-600 hover:text-green-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('activities.create', ['company_id' => $deal->company_id, 'contact_id' => $deal->contact_id]) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Log Activity
                                </a>
                                <a href="{{ route('deals.create', ['company_id' => $deal->company_id, 'contact_id' => $deal->contact_id]) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    New Deal with Same Contact
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>