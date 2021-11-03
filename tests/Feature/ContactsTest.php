<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contact;
use Carbon\Carbon;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testContactAdd()
    {
        // store()へPOST
        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('05/19/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('Test Company', $contact->company);
    }

    /** @test */
    public function testInputRequired()
    {
        collect(['name', 'email', 'birthday', 'company'])->each(function ($item) {
            // store()へPOST
            $response = $this->post(
                '/api/contacts',
                array_merge($this->data(), [$item => ''])
            );

            $response->assertSessionHasErrors($item);
            $this->assertCount(0, Contact::all());
        });
    }

    /** @test */
    public function testEmailValidation()
    {
        // store()へPOST
        $response = $this->post(
            '/api/contacts',
            array_merge($this->data(), ['email' => 'Not an email'])
        );

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function testBirthdayValidation()
    {
        $this->withoutExceptionHandling();

        // store()へPOST
        $response = $this->post(
            '/api/contacts',
            array_merge($this->data(), ['birthday' => 'May 19, 1988'])
        );

        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('05-19-1988', Contact::first()->birthday->format('m-d-Y'));
    }

    /** @test */
    public function testGetContact()
    {
        // 擬似データの生成・取得
        $contact = factory(Contact::class)->create();
        $response = $this->get('/api/contacts/' . $contact->id);

        $response->assertJson([
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'birthday' => $contact->birthday,
            'company' => $contact->company,
        ]);
    }

    /** @test */
    public function testUpdateContact()
    {
        // 擬似データの生成・書き換え
        $contact = factory(Contact::class)->create();
        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());
        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('05/19/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('Test Company', $contact->company);
    }

    /** @test */
    public function testDeleteContact()
    {
        $this->withoutExceptionHandling();
        $contact = factory(Contact::class)->create();
        $response = $this->delete('/api/contacts/' . $contact->id);
        $this->assertCount(0, Contact::all());
    }

    private function data()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@test.com',
            'birthday' => '05/19/1988',
            'company' => 'Test Company',
        ];
    }
}
