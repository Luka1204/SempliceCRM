<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $contact->full_name }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Contact details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('contacts.edit', $contact) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit
                </a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                            onclick="return confirm('Are you sure you want to delete {{ $contact->full_name }}? This action cannot be undone.')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                    <dd class="text-sm text-gray-900">{{ $contact->full_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Position</dt>
                                    <dd class="text-sm text-gray-900">{{ $contact->position ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                                    <dd class="text-sm text-gray-900">{{ $contact->department ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($contact->email)
                                            <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-900">{{ $contact->email }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($contact->phone)
                                            <a href="tel:{{ $contact->phone }}" class="text-blue-600 hover:text-blue-900">{{ $contact->phone }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Company</dt>
                                    <dd class="text-sm text-gray-900">
                                        <a href="{{ route('companies.show', $contact->company) }}" class="text-blue-600 hover:text-blue-900">{{ $contact->company->name }}</a>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Notes -->
                        @if($contact->notes)
                            <div class="sm:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $contact->notes }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Meta Information -->
                        <div class="sm:col-span-2 pt-4 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Meta Information</h3>
                            <dl class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="text-sm text-gray-900">{{ $contact->created_at->format('M j, Y \a\t g:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="text-sm text-gray-900">{{ $contact->updated_at->format('M j, Y \a\t g:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>