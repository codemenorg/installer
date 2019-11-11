<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Services\EnvironmentManager;
use Illuminate\Routing\Controller;

class FinalController extends Controller
{
    public function view($type, $routeConfig)
    {
        app(EnvironmentManager::class)->save(['app_installed' => true]);
        $title = __('Installation Finished');
        return view('vendor.installer.finished',
            compact(
                'type',
                'routeConfig',
                'title'
            )
        );
    }
}
