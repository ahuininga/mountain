<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\App;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AppsTest extends TestCase
{
    private string $type = 'apps';

    public function testCreateApp(): void
    {
        $this->createUserAndLogin();
        $app = App::factory()->make();

        $response = $this->apiCreateModel($app, $this->type);
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('name', $app->name)
                ->etc());
    }

    public function testShowApp(): void
    {
        $this->createUserAndLogin();
        $app = App::factory()->create();

        $response = $this->apiShowModel($app->id, $this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('name', $app->name)
                ->where('id', $app->id)
                ->etc());
    }

    public function testDeleteApp(): void
    {
        $this->createUserAndLogin();
        $app = App::factory()->create();

        $response = $this->apiDeleteModel($app->id, $this->type);
        $response->assertStatus(200);
    }

    public function testUpdateApp(): void
    {
        $this->createUserAndLogin();
        $app = App::factory()->create();
        $app->name = 'my app';

        $response = $this->apiUpdateModel($app, $this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('id', $app->id)
                ->where('name', $app->name)
                ->etc());
    }

    public function testIndexApps(): void
    {
        $this->createUserAndLogin();
        $apps = App::factory(2)->create();
        $app = $apps->sortBy('id')->first();

        $response = $this->apiIndexModel($this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->has('data', 2, fn ($json) => $json->where('id', $app->id)
                ->where('name', $app->name)
                ->etc())
                ->etc());
    }

    public function testGetAppNotAllowed(): void
    {
        $this->createUserAndLogin();
        $app = App::factory()->create();

        //login is other user
        $this->createUserAndLogin();

        $response = $this->apiShowModel($app->id, $this->type);
        $response->assertStatus(404);
    }

    public function testDeleteAppNotAllowed(): void
    {
        $this->createUserAndLogin();
        $app = App::factory()->create();

        //login is other user
        $this->createUserAndLogin();

        $response = $this->apiDeleteModel($app->id, $this->type);
        $response->assertStatus(404);
    }
}
