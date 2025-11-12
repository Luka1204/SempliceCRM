<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create New Deal') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Add a new sales opportunity to your pipeline</p>
            </div>
            <a href="{{ route('deals.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Back to Deals
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('deals.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Deal Name -->
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Deal Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-500 @enderror"
                                       placeholder="e.g., Enterprise Software License"
                                       required>
                                @error('name')
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

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" 
                                           step="0.01" min="0"
                                           class="block w-full pl-7 pr-12 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('amount') border-red-500 @enderror"
                                           placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">USD</span>
                                    </div>
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stage -->
                            <div>
                                <label for="stage" class="block text-sm font-medium text-gray-700">Stage *</label>
                                <select name="stage" id="stage" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('stage') border-red-500 @enderror"
                                        required>
                                    <option value="">Select a stage</option>
                                    @foreach($stages as $key => $name)
                                        <option value="{{ $key }}" {{ old('stage') == $key ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('stage')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expected Close Date -->
                            <div class="sm:col-span-2">
                                <label for="expected_close_date" class="block text-sm font-medium text-gray-700">Expected Close Date</label>
                                <input type="date" name="expected_close_date" id="expected_close_date" 
                                       value="{{ old('expected_close_date') }}" 
                                       min="{{ date('Y-m-d') }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('expected_close_date') border-red-500 @enderror">
                                @error('expected_close_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" 
                                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-500 @enderror"
                                          placeholder="Describe the deal, requirements, and any important details...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('deals.index') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                Create Deal
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