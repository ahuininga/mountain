<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UsersTest extends TestCase
{
    private string $type = 'users';

    public function testCreateUser(): void
    {
        $user = User::factory()->make(['password' => 'password']);
        $user->makeVisible('password');

        $response = $this->apiCreateModel($user, $this->type);
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('name', $user->name)
                ->has('token')
                ->etc());
    }

    public function testShowUser(): void
    {
        $user = $this->createUserAndLogin();
        $response = $this->apiShowModel($user->id, $this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('name', $user->name)
                ->etc());
    }

    public function testDeleteUser(): void
    {
        $user = $this->createUserAndLogin();
        $response = $this->apiDeleteModel($user->id, $this->type);
        $response->assertStatus(200);
    }

    public function testUpdateUser(): void
    {
        $user = $this->createUserAndLogin();
        $user->name = 'tostidetester';
        $response = $this->apiUpdateModel($user, $this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('name', $user->name)
                ->etc());
    }

    public function testIndexUsers(): void
    {
        $user = $this->createUserAndLogin();
        //extra users, should not be shown, only your own user
        User::factory(2)->create();
        $response = $this->apiIndexModel($this->type);
        $response->assertStatus(200)
            ->assertJson(['data' => [$user->toArray()]]);
    }

    public function testGetUserNotAllowed(): void
    {
        $this->createUserAndLogin();
        $user = User::factory()->create();

        $response = $this->apiShowModel($user->id, $this->type);
        $response->assertStatus(404);
    }

    public function testDeleteUserNotAllowed(): void
    {
        $this->createUserAndLogin();
        $user = User::factory()->create();

        $response = $this->apiDeleteModel($user->id, $this->type);
        $response->assertStatus(404);
    }
}
