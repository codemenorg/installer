<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Requests\FormRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class StoreController extends Controller
{
    /**
     * Display the Environment menu page.
     *
     * @param FormRequest $request
     * @param string $type
     * @return View
     * @throws BindingResolutionException
     */
    public function __invoke(FormRequest $request, $type)
    {
        $routeConfig = config('installer.routes.' . $type);
        return app()->make($routeConfig['controller'])
            ->callAction('store',
                compact('request')
            );
    }
}
