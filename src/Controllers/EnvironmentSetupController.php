<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Services\EnvironmentManager;
use Codemen\Installer\Services\FormGenerator;
use Codemen\Installer\Services\FormValidator;
use Illuminate\Http\Request;
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

    public function store(Request $request, $type, $routeConfig)
    {
        $variables = app(FormValidator::class)->validate($request, $routeConfig['fields']);

        $this->runValidators($type, $request);

        app(EnvironmentManager::class)->save($variables);

        return redirect()->route($routeConfig['next_route']['name'], $routeConfig['next_route']['parameters']);
    }

    private function runValidators($type, $request)
    {
        $validators = config('installer.groups.' . $type . '.validator');

        if (is_array($validators)) {
            foreach ($validators as $validator) {
                app($validator)->validate($request, $type);
            }
        } else if (!empty($validators)) {
            app($validators)->validate($request, $type);
        }
    }

}
