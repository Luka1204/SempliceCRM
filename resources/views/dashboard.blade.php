<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('SempliceCRM Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back! Here's what's happening with your business.</p>
            </div>
            <div class="text-sm text-gray-500">
                Last updated: {{ now()->format('M j, Y g:i A') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Companies -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Companies</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['companies_count'] }}</p>
                                <p class="text-xs text-green-600 mt-1">
                                    +{{ $stats['recent_companies_count'] }} this month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Contacts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Contacts</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['contacts_count'] }}</p>
                                <p class="text-xs text-green-600 mt-1">
                                    +{{ $stats['recent_contacts_count'] }} this month
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Rate -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Activity Rate</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ $stats['companies_count'] > 0 ? round(($stats['contacts_count'] / $stats['companies_count']), 1) : 0 }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Contacts per company</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completion -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Profile Completion</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ min(100, max(0, ($stats['companies_count'] + $stats['contacts_count']) * 5)) }}%
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Keep adding data!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <a href="{{ route('companies.create') }}" 
                               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition duration-150">
                                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-2">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Add Company</p>
                                    <p class="text-xs text-gray-500">Create new business</p>
                                </div>
                            </a>

                            <a href="{{ route('contacts.create') }}" 
                               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition duration-150">
                                <div class="flex-shrink-0 bg-green-100 rounded-lg p-2">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Add Contact</p>
                                    <p class="text-xs text-gray-500">New person</p>
                                </div>
                            </a>

                            <a href="{{ route('companies.index') }}" 
                               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition duration-150">
                                <div class="flex-shrink-0 bg-gray-100 rounded-lg p-2">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">View Companies</p>
                                    <p class="text-xs text-gray-500">All businesses</p>
                                </div>
                            </a>

                            <a href="{{ route('contacts.index') }}" 
                               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition duration-150">
                                <div class="flex-shrink-0 bg-gray-100 rounded-lg p-2">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">View Contacts</p>
                                    <p class="text-xs text-gray-500">All people</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Recent Companies -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Recent Companies</h3>
                            <a href="{{ route('companies.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">View all</a>
                        </div>
                        
                        @if($recentCompanies->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentCompanies as $company)
                                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition duration-150 group">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition duration-150">
                                                <span class="text-blue-600 font-semibold text-sm">
                                                    {{ strtoupper(substr($company->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $company->name }}</p>
                                                <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                    <span>{{ $company->email ?? 'No email' }}</span>
                                                    <span>•</span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $company->contacts_count }} contacts
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 whitespace-nowrap">
                                            {{ $company->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No companies yet.</p>
                                <a href="{{ route('companies.create') }}" class="mt-3 inline-flex items-center text-sm text-blue-600 hover:text-blue-900 font-medium">
                                    Add your first company
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Contacts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Recent Contacts</h3>
                            <a href="{{ route('contacts.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">View all</a>
                        </div>
                        
                        @if($recentContacts->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentContacts as $contact)
                                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition duration-150 group">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition duration-150">
                                                <span class="text-green-600 font-semibold text-sm">
                                                    {{ $contact->initials }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $contact->full_name }}</p>
                                                <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                    <span>{{ $contact->position ?? 'No position' }}</span>
                                                    <span>•</span>
                                                    <span class="text-blue-600 hover:text-blue-900">
                                                        {{ $contact->company->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 whitespace-nowrap">
                                            {{ $contact->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No contacts yet.</p>
                                <a href="{{ route('contacts.create') }}" class="mt-3 inline-flex items-center text-sm text-blue-600 hover:text-blue-900 font-medium">
                                    Add your first contact
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Growth Chart Section -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Business Growth</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="text-center">
                            <div class="flex items-center justify-center space-x-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ $stats['companies_count'] }}</div>
                                    <div class="text-sm text-gray-500">Total Companies</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ $stats['contacts_count'] }}</div>
                                    <div class="text-sm text-gray-500">Total Contacts</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">{{ $stats['recent_companies_count'] }}</div>
                                    <div class="text-sm text-gray-500">New This Month</div>
                                </div>
                            </div>
                            <p class="mt-4 text-sm text-gray-500">
                                Your CRM is growing! Keep adding new companies and contacts to build your network.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>