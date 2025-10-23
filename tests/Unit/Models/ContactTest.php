<?php

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->app->make(\Illuminate\Contracts\Http\Kernel::class)
        ->pushMiddleware(\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class);
});

test('can create a contact', function () {
    $contact = Contact::create([
        'code' => 'CUST001',
        'name' => 'John Doe',
        'type' => 'customer',
        'phone' => '1234567890',
        'email' => 'john@example.com',
        'address' => '123 Test Street'
    ]);

    expect($contact)->toBeInstanceOf(Contact::class)
        ->and($contact->code)->toBe('CUST001')
        ->and($contact->name)->toBe('John Doe')
        ->and($contact->type)->toBe('customer');
});

test('contact can be soft deleted', function () {
    $contact = Contact::create([
        'code' => 'CUST001',
        'name' => 'John Doe',
        'type' => 'customer'
    ]);

    $contact->delete();

    expect(Contact::count())->toBe(0)
        ->and(Contact::withTrashed()->count())->toBe(1);
});
