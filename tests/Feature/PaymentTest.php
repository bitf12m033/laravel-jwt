<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_RequiredFieldsForPayment()
    {
        $this->json('POST', 'api/pay', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                    "card_number" => ["The card number field is required."],
                    "card_holder" => ["The card holder field is required."],
                    "expiry" => ["The expiry field is required."],
                    "amount" => ["The amount field is required."],
                    "user_id" => ["The user id field is required."],
                    "cvc" => ["The cvc field is required."],
            ]);
    }

    public function test_SuccessfulPayment()
    {
        $userData = [
            "card_holder" => "John Doe",
            "card_number" => "4242424242424242",
            "expiry" => "03/23",
            "cvc" => "124",
            "amount" => 1200,
            "user_id" => "1",
        ];

        $this->json('POST', 'api/pay', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "payment"=>[
                    '_id',
                    'card_holder',
                    'card_number',
                    'expiry',
                    'cvc',
                    'amount',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
                "response"=>[

                    "message"
                ],
            ]);
    }
}
