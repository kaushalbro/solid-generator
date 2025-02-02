<?php
namespace Devil\Solidprinciple\app\Services;
class SideBar {
    private mixed $name;
    private mixed $icon='fa-solid fa-circle-dot';
    private mixed $redirect_route=null;
    private mixed $title=null;
    private mixed $class=null;
    private mixed $hide=false;
    private mixed $permission=true;
    private mixed $with_count=true;
    private mixed $active_on_route=null;
    private mixed $model= null;
    private ?string $group= null;
    private ?int $order= 9999999;
    private mixed $sub_links=[];
    private static array $collection;
    private static int $no_of_sidebars=0;
    private static int $no_of_groups=0;

    public static function add(mixed $name,$model=null): self
    {
        $sidebar = new self();
        $sidebar->name = $name;
        $sidebar->title= $name;
        $sidebar->model= $model;
        self::$no_of_sidebars++;
        if ($sidebar->group) self::$no_of_groups++;
        self::$collection[] = $sidebar;
        return $sidebar;
    }
    public function model(mixed $model=null): self
    {
        if ($model) $this->model = $model;
        return $this;
    }
    public function group(string $name): self{
        if ($name)
            $this->group = $name;
            self::$no_of_groups++;

         return $this;
    }
    /**
     * Does something interesting
     *
     * @param integer $placing_or_ordering_position place in first position=1, place in second position=2 etc..
     */
    public function position(int $placing_or_ordering_position): self{
        if($placing_or_ordering_position) $this->order =$placing_or_ordering_position;
        return $this;
    }
    public function icon(mixed $icon=null): self
    {
        if ($icon) $this->icon = $icon;
        return $this;
    }
    public function route(mixed $redirect_route, $use_laravel_route=false, $without_domain=true): self
    {
        $this->redirect_route =$redirect_route;
        if ($use_laravel_route) $this->redirect_route = route($use_laravel_route);
        if ($use_laravel_route && $without_domain) $this->redirect_route =  parse_url($this->redirect_route, PHP_URL_PATH);
        return $this;
    }
    public function title(mixed $title=null): self
    {
        if($title) $this->title =$title;
        return $this;
    }
    public function activeOnRoutes(mixed $active_on_route=null): self
    {
        if($active_on_route) $this->active_on_route =$active_on_route;
        return $this;
    }
    public function class(mixed $class=null): self
    {
        if ($class) $this->class = $class;
        return $this;
    }
    public function hide(bool $hide=true): self
    {
        $this->hide = $hide;
        return $this;
    }
    public function withoutCount(bool $count=true): self
    {
        $this->with_count = !$count;
        return $this;
    }
    public function permission(bool $permission=true): self
    {
        $this->permission =$permission;
        return $this;
    }
    public function subLinks(SubLink ...$sub_link): self
    {
        $this->sub_links =$sub_link;
        return $this;
    }
    public static function getAllSidebars(): array
    {
        usort(self::$collection, function($a, $b) { // this function helped by chatGpt
            return $a->order <=> $b->order; // Compare the 'order' keys
        });
        $sidebar=[];
        foreach (self::$collection as $side_bar) {
            $links=[];
            $for_section='core';
            if ($side_bar->group) $for_section=$side_bar->group;
            if (!$side_bar->hide){
                $sidebar[$for_section][$side_bar->name]=
                    [
                        'model'=>$side_bar->model,
                        'title' => $side_bar->title,
                        'name' => $side_bar->name,
                        'total_data'=>$side_bar->with_count&&$side_bar->model?$side_bar->model::all()->count():null,
                        'icon' => $side_bar->icon,
//                        'group'=> $side_bar->group,
//                        'order'=> $side_bar->order,
                        'redirect_route' => $side_bar->redirect_route,
                        'class' => $side_bar->class,
                        'hide' => $side_bar->hide,
                        'permission' => $side_bar->permission,
                    ];
                foreach ($side_bar->sub_links as $sub) {
                    if (!$sub->hide){
                        $sub_build=$sub->build();
                        $sidebar[$for_section][$side_bar->name]['sub_links'][$sub_build['name']] = $sub_build;
                        if(is_array($sub_build['active_on_routes'])) {
                            foreach ($sub_build['active_on_routes'] as $rut){
                                $links[]=$rut;
                            }
                        }else{
                            $links[]=$sub_build['active_on_routes'];
                        }
                    }
                }
                $sidebar[$for_section][$side_bar->name]['active_on_routes'] =array_filter(array_unique(array_merge(is_array($side_bar->active_on_route)?$side_bar->active_on_route:[$side_bar->active_on_route],$links)));
                }
            }
        return $sidebar;
    }
    public static function getSidebarMetadata(): array
    {
        return self::getAllSidebars();
    }
    public function build(): string|array|false
    {
        $data =[
            $this->name=>[
                'model'=>$this->model,
                'title' => $this->title,
                'name' => $this->name,
                'total_data'=>$this->with_count&&$this->model?$this->model::all()->count():null,
                'icon' => $this->icon,
                'group'=> $this->group,
                'order'=> $this->order,
                'redirect_route' => $this->redirect_route,
                'class' => $this->class,
                'hide' => $this->hide,
                'active_on_routes' => $this->active_on_route,
                'permission' => $this->permission,
                'sub_links' =>  array_map(function($sublink) {
                    if (!$sublink->hide)
                        return $sublink->build();
                    return [];
                }, $this->sub_links),
            ]
        ];
        if (request()->wantsJson()) return json_encode($data);
        return $data;
    }
}
