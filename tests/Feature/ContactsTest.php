<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

use App\Contact;
use App\User;
use Carbon\Carbon;


class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function testRedirectToLogin()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['api_token' => '']));
        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function testRelateUserWithContact()
    {
        $user = factory(User::class)->create();
        $another_user = factory(User::class)->create();

        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $another_contact = factory(Contact::class)->create(['user_id' => $another_user->id]);

        $response = $this->get('/api/contacts?api_token=' . $user->api_token);

        $response->assertJsonCount(1)->assertJson([
            'data' => [
                ['contact_id' => $contact->id],
            ],
        ]);
    }

    /** @test */
    public function testContactAdd()
    {
        $this->withoutExceptionHandling();

        // store()へPOST
        $response = $this->post('/api/contacts', $this->data());


        $contact = Contact::first();
        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('05/19/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('Test Company', $contact->company);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'company' => $contact->company,
                'last_updated' => $contact->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => url('/contacts/' . $contact->id),
            ],
        ]);
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
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'company' => $contact->company,
                'last_updated' => $contact->updated_at->diffForHumans(),
            ]
        ]);
    }

    /** @test */
    public function testNotGetRelatedContact()
    {
        // 擬似データの生成・取得
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $another_user = factory(User::class)->create();
        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $another_user->api_token);

        $response->assertStatus(403);
    }

    /** @test */
    public function testUpdateContact()
    {
        // 擬似データの生成・書き換え
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->patch('/api/contacts/' . $contact->id, $this->data());
        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('05/19/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('Test Company', $contact->company);
    }

    /** @test */
    public function testUpdateNotRelatedContact()
    {
        // 擬似データの生成・書き換え
        $contact = factory(Contact::class)->create();
        $another_user = factory(User::class)->create();

        $response = $this->patch(
            '/api/contacts/' . $contact->id,
            array_merge($this->data(), ['api_token' => $another_user->api_token])
        );

        $response->assertStatus(403);
    }

    /** @test */
    public function testDeleteContact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $this->user->api_token]);
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function testDeleteNotRelatedContact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $another_user = factory(User::class)->create();

        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $another_user->api_token]);
        $response->assertStatus(403);
    }

    private function data()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@test.com',
            'birthday' => '05/19/1988',
            'company' => 'Test Company',
            'api_token' => $this->user->api_token,
        ];
    }
}
