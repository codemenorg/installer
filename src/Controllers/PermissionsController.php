<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Services\PermissionService;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PermissionsController extends Controller
{
    /**
     * @var PermissionService
     */
    private $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display the permissions check page.
     *
     * @param $type
     * @param $routeConfig
     * @return View
     */
    public function view($type, $routeConfig)
    {
        $permissions = $this->permissionService->check(
            config('installer.permissions')
        );

        $title = ucwords(str_replace('-', ' ', $type));

        return view('vendor.installer.permissions',
            compact(
                'permissions',
                'type',
                'routeConfig',
                'title'
            )
        );
    }
}
