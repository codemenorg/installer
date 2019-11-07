<?php

namespace Codemen\Installer\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ViewController extends Controller
{
    /**
     * Display the Environment menu page.
     *
     * @param string $type
     * @return View
     * @throws BindingResolutionException
     */
    public function __invoke($type)
    {
        $routeConfig = config('installer.routes.' . $type);
        return app()->make($routeConfig['controller'])->callAction('view', compact('type', 'routeConfig'));
    }
}
