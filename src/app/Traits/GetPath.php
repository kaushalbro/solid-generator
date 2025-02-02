<?php
namespace Devil\Solidprinciple\app\Traits;
trait GetPath
{
    /**
     * Get path from base path
     * @param string $path_to Path to.
     * @return
     * 'controller'=>app/Http/Controllers,
     * 'model'=>app/Models,
     * 'request'=>app/Http/Requests,
     *  'view'=>resources/views,
     * 'admin_view'=>resources/views/admin,
     *  'view_backend'=>resources/views/backend/admin/backend,
     * 'view_admin_common'=>resources/views/backend/admin/backend/common,
     * .
     */
    public function path(string $path_to): string
    {
        switch ($path_to) {
            case 'controller':
                $path = config('solid.controller_path');
                break;
            case 'model':
                $path = config('solid.model_path');
                break;
            case 'repository':
                $path = config('solid.repo_path');
                break;
            case 'config':
                $path = 'config';
                break;
            case 'request':
                $path = config('solid.request_path');
                break;
            case 'view':
                $path = config('solid.view_path');
                break;
            case 'seeder_path':
                $path = config('solid.seeder_path');
                break;
            case 'view_admin':
                $path = config('solid.backend_admin_view_path');
                break;
            case 'view_admin_common':
                $path = config('solid.backend_admin_view_path').'/common';
                break;
            default:
                $path = '';
                break;
        }
        return $path;
    }
    public function stub(){
        return __DIR__.'/../stubs/';
    }
    public function admin_stub(){
        return __DIR__.'/../stubs/admin_view';
    }
}
