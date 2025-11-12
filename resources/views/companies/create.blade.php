<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create Company') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Add a new company to your CRM</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-companies.form action="{{ route('companies.store') }}" method="POST" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>