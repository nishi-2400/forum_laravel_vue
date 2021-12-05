<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BirthdayTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchCurrentBirthday()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $birthdayContact = factory(Contact::class)->create([
            'user_id' => $user->id,
            'birthday' => now()->subYear(),
        ]);

        $noBirthdayContact = factory(Contact::class)->create([
            'user_id' => $user->id,
            'birthday' => now()->subMonth(),
        ]);

        $this->get('/api/birthdays?api_token=' . $user->api_token)->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => [
                        'contact_id' => $birthdayContact->id,
                    ],

                ],
            ]
        ]);
    }
}
