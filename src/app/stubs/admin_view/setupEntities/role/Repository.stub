<?php
namespace App\Repositories;
use App\Models\Role;

class RoleRepository extends SolidBaseRepository
{
     protected $model;
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

   public function getFillable(){
        return $this->model->getFillable();
    }


}
