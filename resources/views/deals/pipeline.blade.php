<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Sales Pipeline') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Visual overview of all deals in your pipeline</p>
            </div>
            <a href="{{ route('deals.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                List View
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Pipeline Stats -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-4">
                @php
                    $totalPipeline = 0;
                    $openDealsCount = 0;
                    foreach ($dealsByStage as $stageDeals) {
                        $totalPipeline += $stageDeals->sum('amount');
                        if (!in_array($stageDeals->first()->stage ?? '', ['closed_won', 'closed_lost'])) {
                            $openDealsCount += $stageDeals->count();
                        }
                    }
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Pipeline</p>
                                <p class="text-2xl font-semibold text-gray-900">${{ number_format($totalPipeline, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Open Deals</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $openDealsCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Won Deals</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $dealsByStage['closed_won']->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Lost Deals</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $dealsByStage['closed_lost']->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pipeline Columns -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-6">
                @foreach($stages as $key => $name)
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-medium text-gray-900">{{ $name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-gray-800">
                            {{ $dealsByStage[$key]->count() }}
                        </span>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($dealsByStage[$key] as $deal)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-150">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $deal->name }}</h4>
                            </div>
                            
                            <div class="mb-2">
                                <p class="text-xs text-gray-500 truncate">{{ $deal->company->name }}</p>
                                @if($deal->contact)
                                <p class="text-xs text-gray-400 truncate">{{ $deal->contact->full_name }}</p>
                                @endif
                            </div>
                            
                            @if($deal->amount)
                            <p class="text-sm font-semibold text-gray-900 mb-2">${{ number_format($deal->amount, 2) }}</p>
                            @endif
                            
                            @if($deal->expected_close_date)
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>Closes {{ $deal->expected_close_date->format('M j') }}</span>
                                @if($deal->expected_close_date->isPast() && !$deal->is_closed)
                                <span class="text-red-500">Overdue</span>
                                @endif
                            </div>
                            @endif
                            
                            <div class="mt-3 flex space-x-1">
                                <a href="{{ route('deals.show', $deal) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-2 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500">
                                    View
                                </a>
                                @if(!$deal->is_closed)
                                <form action="{{ route('deals.mark-won', $deal) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-green-500"
                                            onclick="return confirm('Mark as won?')"
                                            title="Mark Won">
                                        ✓
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        
                        @if($dealsByStage[$key]->count() === 0)
                        <div class="text-center py-8">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p class="mt-2 text-xs text-gray-500">No deals in this stage</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>