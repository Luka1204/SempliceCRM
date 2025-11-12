<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Models\Company;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService
    ) {
        $this->authorizeResource(Contact::class, 'contact');
    }

    public function index(Request $request): View
    {
        $contacts = $this->contactService->getUserContacts($request->user());

        return view('contacts.index', compact('contacts'));
    }

    public function create(): View
    {
        $companies = Company::byUser(auth()->user())->get();

        return view('contacts.create', compact('companies'));
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $this->contactService->createContact($request->validated(), $request->user());

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact): View
    {
        $contact->load('company');

        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact): View
    {
        $companies = Company::byUser(auth()->user())->get();

        return view('contacts.edit', compact('contact', 'companies'));
    }

    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $this->contactService->updateContact($contact, $request->validated());

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $this->contactService->deleteContact($contact);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    public function search(Request $request): View
    {
        $contacts = $this->contactService->searchContacts(
            $request->user(), 
            $request->get('search', '')
        );

        return view('contacts.index', compact('contacts'));
    }

    public function byCompany(Request $request, Company $company): View
    {
        $this->authorize('view', $company);
        
        $contacts = $this->contactService->getContactsByCompany(
            $request->user(), 
            $company->id
        );

        return view('contacts.index', compact('contacts', 'company'));
    }
}