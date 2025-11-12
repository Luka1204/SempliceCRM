<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Contact') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Update contact information</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-contacts.form :contact="$contact" :companies="$companies" action="{{ route('contacts.update', $contact) }}" method="PUT" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>