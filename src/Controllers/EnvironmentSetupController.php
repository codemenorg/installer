<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Requests\FormRequest;
use Codemen\Installer\Services\EnvironmentManager;
use Codemen\Installer\Services\FormGenerator;
use Illuminate\Routing\Controller;

class EnvironmentSetupController extends Controller
{
    public function view($type, $routeConfig)
    {
        $storeRouteName = route('installer.types.store', $type);
        $form = app(FormGenerator::class)->generate($routeConfig['fields'], $storeRouteName);
        $title = ucwords(str_replace('-', ' ', $type));
        return view('vendor.installer.environment',
            compact(
                'type',
                'routeConfig',
                'storeRouteName',
                'form',
                'title'
            )
        );
    }

    public function store(FormRequest $request)
    {
        $routeConfig = $request->getRouteConfig();
        $variables = $request->validated();
        app(EnvironmentManager::class)->save($variables);
        return redirect()->route($routeConfig['next_route']['name'], $routeConfig['next_route']['parameters']);
    }
}
