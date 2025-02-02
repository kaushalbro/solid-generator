<?php
namespace Devil\Solidprinciple\app\Services;
class SubLink
{
    private mixed $name;
    private mixed $icon = 'fa fa-circle';
    private mixed $route = null;
    private mixed $title = null;
    public bool $hide = false;
    private bool $permission = true;
    private bool $with_count = true;
    private mixed $active_on_route=false;
    private mixed $model= null;
    public static function add(mixed $name,$model=null): self
    {
        $sub_link = new self();
        $sub_link->name = $name;
        $sub_link->title= $name;
        $sub_link->model= $model;
        return $sub_link;

    }
    public function model(mixed $model=null): self
    {
        if ($model) $this->model = $model;
        return $this;
    }
    public function activeOnRoutes(mixed $active_on_route=null):self
    {
        if ($active_on_route) $this->active_on_route=$active_on_route;
        return $this;
    }
    public function icon(mixed $icon = null): self
    {
        if($icon) $this->icon = $icon;
        return $this;
    }
    public function route(mixed $redirect_route, bool $use_laravel_route=false,bool $without_domain=true): self
    {
        $this->route =$redirect_route;
        if ($use_laravel_route) $this->route =route($use_laravel_route);
        if($use_laravel_route && $without_domain) $this->route = parse_url($this->route, PHP_URL_PATH);
        return $this;
    }
    public function title(mixed $title = null): self
    {
        if($title) $this->title = $title;
        return $this;
    }
    public function hide(bool $hide = true): self
    {
        $this->hide = $hide;
        return $this;
    }
    public function permission(bool $permission = true): self{
        $this->permission = $permission;
        return $this;
    }
    public function withoutCount(bool $count=false): self
    {
        $this->with_count = $count;
        return $this;
    }
    public function build(): array
    {
       return  [
            'name' => $this->name,
            'icon' => $this->icon,
            'model' =>$this->model,
            'total_data'=>$this->with_count&&$this->model?$this->model::all()->count():null,
            'redirect_route' => $this->route,
            'title' => $this->title,
            'active_on_routes'=>array_unique(array_merge(is_array($this->active_on_route)?$this->active_on_route:[$this->active_on_route],[$this->route])),
            'hide' => $this->hide,
            'permission' => $this->permission,
        ];
    }
}

