<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * test the permits to access
     *
     * @return void
     */
    public function test_show_missing_permits()
    {
        $response = $this->get('api/users/1');

        $response->assertStatus(401)
            ->assertJson([]);
    }

    /**
     * test the user list
     *
     * @return void
     */
    public function test_list()
    {
        $response = $this->get('api/users');

        $response->assertStatus(200)
            ->assertJson([
                [
                    "id"                => 1,
                    "name"              => "juan carlos",
                    "email"             => "jgiraldo@truora.com",
                    "email_verified_at" => null,
                    "role_id"           => 1,
                    "created_at"        => "2022-11-24T14:10:06.000000Z",
                    "updated_at"        => "2022-11-24T14:10:06.000000Z",
                    "role"              => [
                        "id"         => 1,
                        "name"       => "role 1",
                        "created_at" => "2022-11-24T14:07:24.000000Z",
                        "updated_at" => "2022-11-24T14:07:24.000000Z",
                    ],
                    "profile"           => [
                        "id"           => 5,
                        "phone_number" => "3137885484",
                        "image"        => "1669301170e6b98816d2064829961301e59c90b0b5.png",
                        "url_facebook" => "https://www.facebook.com/juancarlos.giraldorios.73",
                        "user_id"      => 1,
                        "created_at"   => "2022-11-24T14:46:10.000000Z",
                        "updated_at"   => "2022-11-24T14:46:10.000000Z",
                    ],
                ],
            ]);
    }
}
