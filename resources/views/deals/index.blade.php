<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Deals') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manage your sales pipeline</p>
            </div>
            <a href="{{ route('deals.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Add Deal') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-5">
                <!-- Total Deals -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-4">
                        <div class="text-sm font-medium text-gray-500">Total Deals</div>
                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</div>
                    </div>
                </div>

                <!-- Open Deals -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-4">
                        <div class="text-sm font-medium text-gray-500">Open Deals</div>
                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['open'] }}</div>
                    </div>
                </div>

                <!-- Closed Deals -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-4">
                        <div class="text-sm font-medium text-gray-500">Closed Deals</div>
                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['closed'] }}</div>
                    </div>
                </div>

                <!-- Won Deals -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-teal-500">
                    <div class="p-4">
                        <div class="text-sm font-medium text-gray-500">Won Deals</div>
                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['won'] }}</div>
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-4">
                        <div class="text-sm font-medium text-gray-500">Total Amount</div>
                        <div class="text-2xl font-semibold text-gray-900">${{ number_format($stats['total_amount'], 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Stage Filters -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('deals.index') }}" 
                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ !request()->has('stage') && !request()->routeIs('deals.upcoming') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            All Deals
                        </a>
                        @foreach(Deal::STAGES as $key => $stage)
                            <a href="{{ route('deals.by-stage', $key) }}" 
                               class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ request('stage') == $key ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                {{ $stage }}
                            </a>
                        @endforeach
                        <a href="{{ route('deals.upcoming') }}" 
                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ request()->routeIs('deals.upcoming') ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            Upcoming
                        </a>
                    </div>
                </div>
            </div>

            <!-- Deals Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    @if($deals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Deal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Company & Contact
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stage
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Close Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($deals as $deal)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $deal->name }}</div>
                                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($deal->description, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <a href="{{ route('companies.show', $deal->company) }}" class="text-blue-600 hover:text-blue-900">
                                                        {{ $deal->company->name }}
                                                    </a>
                                                </div>
                                                @if($deal->contact)
                                                <div class="text-sm text-gray-500">
                                                    <a href="{{ route('contacts.show', $deal->contact) }}" class="text-green-600 hover:text-green-900">
                                                        {{ $deal->contact->full_name }}
                                                    </a>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @if($deal->amount)
                                                        ${{ number_format($deal->amount, 2) }}
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $deal->stage === 'closed_won' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $deal->stage === 'closed_lost' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ in_array($deal->stage, ['prospect', 'qualification']) ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ in_array($deal->stage, ['proposal', 'negotiation']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                    {{ $deal->stage_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if($deal->expected_close_date)
                                                        {{ $deal->expected_close_date->format('M j, Y') }}
                                                        @if($deal->expected_close_date->isPast() && !$deal->is_closed)
                                                            <span class="text-red-500 text-xs ml-1">Overdue</span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('deals.show', $deal) }}" 
                                                       class="text-blue-600 hover:text-blue-900 transition duration-150"
                                                       title="View Details">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('deals.edit', $deal) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900 transition duration-150"
                                                       title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                    @if(!$deal->is_closed)
                                                        <form action="{{ route('deals.close-won', $deal) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="text-green-600 hover:text-green-900 transition duration-150"
                                                                    title="Mark as Won"
                                                                    onclick="return confirm('Mark this deal as won?')">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('deals.close-lost', $deal) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="text-red-600 hover:text-red-900 transition duration-150"
                                                                    title="Mark as Lost"
                                                                    onclick="return confirm('Mark this deal as lost?')">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('deals.destroy', $deal) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition duration-150"
                                                                onclick="return confirm('Are you sure you want to delete this deal? This action cannot be undone.')"
                                                                title="Delete">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $deals->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No deals</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating your first deal.</p>
                            <div class="mt-6">
                                <a href="{{ route('deals.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Deal
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>