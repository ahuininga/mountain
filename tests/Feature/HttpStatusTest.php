<?php

namespace Tests\Feature;

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
        foreach ($this->allRoutes['GET'] as $route) {
            $action = $route->getActionname();
            if($action == "Closure"){
                continue;
            }

            $this->refreshApplication();

            if (strpos($route->uri, '{id}')) {
                $route->uri = $this->getModelId($route);
            }

            $this->get($route->uri)->assertOk();
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
            $this->patch($route->uri, [], ['Accept' => 'application/json'])->assertOk();
        }
    }

    public function testDelete()
    {
        foreach ($this->allRoutes['DELETE'] as $route) {
            $action = $route->getActionname();
            if($action == "Closure"){
                continue;
            }
            $this->refreshApplication();
            $this->seed();

            $route->uri = $this->getModelId($route);
            $this->delete($route->uri)->assertStatus(204);
            $this->get($route->uri)->assertStatus(404);
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
