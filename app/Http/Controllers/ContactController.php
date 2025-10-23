<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::query()
            ->orderBy('name')
            ->paginate(10);
            
        return Inertia::render('master/contacts/Index', [
            'contacts' => [
                'data' => $contacts->items(),
                'meta' => [
                    'total' => $contacts->total(),
                    'per_page' => $contacts->perPage(),
                    'current_page' => $contacts->currentPage(),
                    'last_page' => $contacts->lastPage(),
                    'path' => $contacts->path(),
                ],
                'links' => [
                    'prev' => $contacts->previousPageUrl(),
                    'next' => $contacts->nextPageUrl(),
                ]
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('master/contacts/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:contacts,code',
            'name' => 'required',
            'type' => 'required|in:customer,vendor',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'notes' => 'nullable',
        ]);

        Contact::create($validated);

        return redirect()->route('master.contacts.index')
            ->with('message', 'Contact created successfully');
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('master/contacts/Form', [
            'contact' => $contact
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'code' => 'required|unique:contacts,code,'.$contact->id,
            'name' => 'required',
            'type' => 'required|in:customer,vendor',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'notes' => 'nullable',
        ]);

        $contact->update($validated);

        return redirect()->route('master.contacts.index')
            ->with('message', 'Contact updated successfully');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('master.contacts.index')
            ->with('message', 'Contact deleted successfully');
    }
}
