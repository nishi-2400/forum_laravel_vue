<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contact;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testContactAdd()
    {
        $this->withExceptionHandling();
        $this->post('/api/contacts', ['name' => 'Test Name']);
        $this->assertCount(1, Contact::all());
    }
}
