<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Log New Activity') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Record an interaction or schedule a task</p>
            </div>
            <a href="{{ route('activities.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Back to Activities
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('activities.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Activity Type -->
                            <div class="sm:col-span-2">
                                <label for="type" class="block text-sm font-medium text-gray-700">Activity Type *</label>
                                <select name="type" id="type" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('type') border-red-500 @enderror"
                                        required>
                                    <option value="">Select activity type</option>
                                    @foreach($types as $key => $name)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Title -->
                            <div class="sm:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('title') border-red-500 @enderror"
                                       placeholder="Brief description of the activity"
                                       required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company -->
                            <div class="sm:col-span-2">
                                <label for="company_id" class="block text-sm font-medium text-gray-700">Company *</label>
                                <select name="company_id" id="company_id" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('company_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Select a company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" 
                                                {{ old('company_id', $preSelectedCompany) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact -->
                            <div class="sm:col-span-2">
                                <label for="contact_id" class="block text-sm font-medium text-gray-700">Contact (Optional)</label>
                                <select name="contact_id" id="contact_id" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('contact_id') border-red-500 @enderror">
                                    <option value="">Select a contact (optional)</option>
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact->id }}" 
                                                {{ old('contact_id', $preSelectedContact) == $contact->id ? 'selected' : '' }}
                                                data-company-id="{{ $contact->company_id }}">
                                            {{ $contact->full_name }} - {{ $contact->company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('contact_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Scheduled Date -->
                            <div>
                                <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Scheduled Date & Time</label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                                       value="{{ old('scheduled_at') }}" 
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('scheduled_at') border-red-500 @enderror"
                                       min="{{ now()->format('Y-m-d\TH:i') }}">
                                @error('scheduled_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('status') border-red-500 @enderror">
                                    @foreach($statuses as $key => $name)
                                        <option value="{{ $key }}" {{ old('status', 'scheduled') == $key ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" 
                                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-500 @enderror"
                                          placeholder="Detailed notes about the activity...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('activities.index') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                Log Activity
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dynamic contact filtering based on selected company
        document.getElementById('company_id').addEventListener('change', function() {
            const companyId = this.value;
            const contactSelect = document.getElementById('contact_id');
            const options = contactSelect.options;
            
            // Show all contacts when no company is selected
            if (!companyId) {
                for (let i = 0; i < options.length; i++) {
                    options[i].style.display = '';
                }
                return;
            }
            
            // Filter contacts by company
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.value === '' || option.getAttribute('data-company-id') === companyId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            }
            
            // Reset contact selection if it doesn't belong to the selected company
            const selectedContact = contactSelect.value;
            if (selectedContact) {
                const selectedOption = contactSelect.options[contactSelect.selectedIndex];
                if (selectedOption.getAttribute('data-company-id') !== companyId) {
                    contactSelect.value = '';
                }
            }
        });

        // Initialize the form with pre-selected values
        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('company_id');
            if (companySelect.value) {
                companySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>