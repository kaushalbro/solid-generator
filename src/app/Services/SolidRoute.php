<?php

namespace Devil\Solidprinciple\app\Services;
use Illuminate\Support\Facades\Route;

class SolidRoute
{
    private mixed $method=null;
    private mixed $uri=null;
    private mixed $middleware=null;
    private mixed $prefix=null;
    private mixed $group=null;
    private mixed $name=null;
    private mixed $as;
    private mixed $controller=null;
    private static array $routes=[];

    public static function uri(mixed $uri): SolidRoute
    {
        $solid_route = new self();
        $solid_route->uri = $uri;
        $solid_route->build();
        self::$routes[] = $solid_route ;

        return $solid_route;
    }
    public function method(mixed $method): self
    {
        $this->method=$method;
        return $this;
    }
    public function middleware(mixed $middleware): self
    {
        $this->middleware=$middleware;
        return $this;
    }
    public function prefix(mixed $prefix): self
    {
        $this->prefix=$prefix;
        return $this;
    }
    public function group(mixed $group, $routes=null): self
    {
        $this->group=$group;
        return $this;
    }
    public function name(mixed $name): self
    {
        $this->name=$name;
        return $this;
    }
        public function as(mixed $as): self
    {
        $this->as=$as;
        return $this;
    }
    public function controller(mixed $controller): self
    {

        $this->controller=$controller;
        return $this;
    }
    public function build(): void
    {
        $this->generateSingleRoute();
    }
    public function generateSingleRoute()
    {
        $route=Route::{$this->method??'get'}($this->uri??'',$this->controller??[]);
        if ($this->name) $route->name($this->name);
        if ($this->middleware) $route->middleware($this->middleware);
        return $route;
    }
    public function generateGroupedDynamicRoute(): array
    {
        return [];
    }
}
