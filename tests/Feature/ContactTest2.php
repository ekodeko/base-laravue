<?php

namespace Tests\Feature;

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
        ->get('/master/contacts');

    $response->assertOk()
        ->assertInertia(fn ($assert) => $assert
            ->component('master/contacts/Index')
            ->has('contacts.data', 1)
        );
});

test('can create a contact', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user, 'web')
        ->post('/master/contacts', [
            'code' => 'CUST002',
            'name' => 'John Doe',
            'type' => 'customer',
            'phone' => '1234567890',
            'email' => 'john@example.com',
            'address' => '123 Test Street'
        ]);

    $response->assertRedirect('/master/contacts');
    expect(Contact::count())->toBe(1);

    $contact = Contact::first();
    expect($contact->code)->toBe('CUST002')
        ->and($contact->name)->toBe('John Doe');
});

test('cannot create contact with duplicate code', function () {
    $user = User::factory()->create();
    
    Contact::create([
        'code' => 'CUST001',
        'name' => 'John Doe',
        'type' => 'customer'
    ]);

    $response = $this->actingAs($user, 'web')
        ->post('/master/contacts', [
            'code' => 'CUST001', // duplicate code
            'name' => 'Jane Doe',
            'type' => 'customer'
        ]);

    $response->assertSessionHasErrors(['code']);
    expect(Contact::count())->toBe(1);
});

test('can update a contact', function () {
    $user = User::factory()->create();
    
    $contact = Contact::create([
        'code' => 'CUST001',
        'name' => 'John Doe',
        'type' => 'customer'
    ]);

    $response = $this->actingAs($user, 'web')
        ->put("/master/contacts/{$contact->id}", [
            'code' => 'CUST001',
            'name' => 'Jane Doe',
            'type' => 'customer'
        ]);

    $response->assertRedirect('/master/contacts');
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

    $response = $this->actingAs($user, 'web')
        ->delete("/master/contacts/{$contact->id}");

    $response->assertRedirect('/master/contacts');
    expect(Contact::count())->toBe(0)
        ->and(Contact::withTrashed()->count())->toBe(1);
});
