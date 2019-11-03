<?php

namespace Codemen\Installer\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class StoreController extends Controller
{
    /**
     * Display the Environment menu page.
     *
     * @param Request $request
     * @param string $type
     * @return View
     * @throws BindingResolutionException
     */
    public function __invoke(Request $request, $type)
    {
        $routeConfig = config('installer.routes.' . $type);
        return app()->make($routeConfig['controller'])
            ->callAction('store',
                compact('request', 'type', 'routeConfig')
            );
    }
}
