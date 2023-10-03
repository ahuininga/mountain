<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\App;
use App\Models\Url;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UrlsTest extends TestCase
{
    private string $type = 'urls';

    public function testCreateUrl(): void
    {
        $this->createUserAndLogin();
        $url = Url::factory()
            ->for(App::factory()->create())
            ->make(['url' => 'https://test.com']);

        $response = $this->apiCreateModel($url, $this->type);
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('url', $url->url)
                ->etc());
    }

    public function testShowUrl(): void
    {
        $this->createUserAndLogin();
        $url = Url::factory()
            ->for(App::factory()->create())
            ->create();

        $response = $this->apiShowModel($url->id, $this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('url', $url->url)
                ->where('id', $url->id)
                ->etc());
    }

    public function testDeleteUrl(): void
    {
        $this->createUserAndLogin();
        $url = Url::factory()
            ->for(App::factory()->create())
            ->create();

        $response = $this->apiDeleteModel($url->id, $this->type);
        $response->assertStatus(200);
    }

    public function testUpdateUrl(): void
    {
        $this->createUserAndLogin();
        $url = Url::factory()
            ->for(App::factory()->create())
            ->create();
        $url->url = 'https://test.com';
        unset($url->app_id);

        $response = $this->apiUpdateModel($url, $this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('id', $url->id)
                ->where('url', $url->url)
                ->etc());
    }

    public function testIndexApps(): void
    {
        $this->createUserAndLogin();
        $urls = Url::factory(2)
            ->for(App::factory()->create())
            ->create();
        $url = $urls->sortBy('id')->first();

        $response = $this->apiIndexModel($this->type);
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->has('data', 2, fn ($json) => $json->where('id', $url->id)
                ->where('url', $url->url)
                ->etc())
                ->etc());
    }
}
