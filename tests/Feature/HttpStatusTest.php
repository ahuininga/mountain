<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class HttpStatusTest extends TestCase
{
    private $allRoutes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->allRoutes = Route::getRoutes()->getRoutesByMethod();
        $this->seed();
    }

    public function testGet()
    {
        $this->seed();
        foreach ($this->allRoutes['GET'] as $route) {
            if (stripos($route->uri, '_ignition') !== false) {
                continue;
            }
            $this->refreshApplication();

            if (strpos($route->uri, '{id}')) {
                $route->uri = $this->getModelId($route);
            }

            $this->get($route->uri)->assertOk();
        }
    }

    public function testDelete()
    {
        $this->seed();
        foreach ($this->allRoutes['DELETE'] as $route) {
            if (stripos($route->uri, '_ignition') !== false) {
                continue;
            }
            $this->refreshApplication();
            $route->uri = $this->getModelId($route);
            $this->delete($route->uri)->assertStatus(204);
            $this->get($route->uri)->assertStatus(404);
        }
    }

    public function testPost()
    {
        foreach ($this->allRoutes['POST'] as $route) {
            if (stripos($route->uri, '_ignition') !== false) {
                continue;
            }
            $this->refreshApplication();
            $model = factory(get_class($this->getModel($route)))->make();
            $data = $model->toArray();
            $data['password'] = 'secret';
            $this->post($route->uri, $data, ['Accept' => 'application/json'])->assertOk();
        }
    }

    public function testPatch()
    {
        foreach ($this->allRoutes['PATCH'] as $route) {
            $this->refreshApplication();
            if (strpos($route->uri, '{id}')) {
                $route->uri = $this->getModelId($route);
            }

            $this->patch($route->uri, ['firstname' => 'voornaam'], ['Accept' => 'application/json'])->assertOk();
        }
    }

    private function getModelId(\Illuminate\Routing\Route $route)
    {
        $model = $route->getController()->model->first();
        return str_replace('{id}', $model->id, $route->uri);
    }

    private function getModel(\Illuminate\Routing\Route $route)
    {
        return $route->getController()->model;
    }
}
