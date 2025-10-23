<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list contacts', function () {
    $user = User::factory()->create();
    
    Contact::create([
        'code' => 'CUST001',
        'name' => 'John Doe',
        'type' => 'customer'
    ]);

    $response = $this->actingAs($user, 'web')
        ->get('/contacts');

    $response->assertOk()
        ->assertInertia(fn ($assert) => $assert
            ->component('Contacts/Index')
            ->has('contacts.data', 1)
        );
});

test('can create a contact', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/contacts', [
            'code' => 'CUST001',
            'name' => 'John Doe',
            'type' => 'customer',
            'phone' => '1234567890',
            'email' => 'john@example.com',
            'address' => '123 Test Street'
        ]);

    $response->assertRedirect('/contacts');
    expect(Contact::count())->toBe(1);

    $contact = Contact::first();
    expect($contact->code)->toBe('CUST001')
        ->and($contact->name)->toBe('John Doe');
});

test('can update a contact', function () {
    $user = User::factory()->create();
    
    $contact = Contact::create([
        'code' => 'CUST001',
        'name' => 'John Doe',
        'type' => 'customer'
    ]);

    $response = $this->actingAs($user)
        ->put("/contacts/{$contact->id}", [
            'code' => 'CUST001',
            'name' => 'Jane Doe',
            'type' => 'customer'
        ]);

    $response->assertRedirect('/contacts');
    $contact->refresh();
    expect($contact->name)->toBe('Jane Doe');
});

test('can delete a contact', function () {
    $user = User::factory()->create();
    
    $contact = Contact::create([
        'code' => 'CUST001',
        'name' => 'John Doe',
        'type' => 'customer'
    ]);

    $response = $this->actingAs($user)
        ->delete("/contacts/{$contact->id}");

    $response->assertRedirect('/contacts');
    expect(Contact::count())->toBe(0)
        ->and(Contact::withTrashed()->count())->toBe(1);
});
