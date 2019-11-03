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
//        /*/*$data['form'] = FormGenerator::generate($type, 'installer.configuration.store');
//        $data['type'] = ucwords(str_replace('_', '', $type));*/
//        return view('vendor.installer.environment', $data);*/
    }
}
