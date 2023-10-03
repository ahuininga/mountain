<?php

namespace Tests;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    private string $apiUrl = 'api/v1/';

    protected function apiCreateModel(Model $model, string $type): TestResponse
    {
        return $this->post($this->getApiUrl($type), $model->toArray());
    }

    protected function apiShowModel(string $id, string $type): TestResponse
    {
        $url = $this->getApiUrl($type).'/'.$id;

        return $this->get($url);
    }

    protected function apiDeleteModel(string $id, string $type): TestResponse
    {
        $url = $this->getApiUrl($type).'/'.$id;

        return $this->delete($url);
    }

    protected function apiUpdateModel(Model $model, string $type): TestResponse
    {
        $url = $this->getApiUrl($type).'/'.$model->id;

        return $this->put($url, $model->toArray());
    }

    protected function apiIndexModel(string $type): TestResponse
    {
        return $this->get($this->getApiUrl($type));
    }

    protected function createUserAndLogin(): Collection|Model
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    private function getApiUrl(string $type): string
    {
        return $this->apiUrl.$type;
    }
}
