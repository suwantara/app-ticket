<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Page;

uses(RefreshDatabase::class);

test('the application returns a successful response', function () {
    // Create home page for the test
    Page::create([
        'title' => 'Home',
        'slug' => 'home',
        'content' => 'Welcome to Ferry Ticket Booking',
        'is_published' => true,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
});
