<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Services\FormGenerator;
use Codemen\Installer\Services\FormValidator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

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

    /**
     * TODO: We can remove this code if PR will be merged: https://github.com/RachidLaasri/LaraframeInstaller/pull/162
     * Validate database connection with user credentials (Form Wizard).
     *
     * @param Request $request
     * @return bool
     */
    private function checkDatabaseConnection(Request $request)
    {
        $connection = $request->input('database_connection');

        $settings = config("database.connections.$connection");

        config([
            'database' => [
                'default' => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver' => $connection,
                        'host' => $request->input('database_hostname'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ]),
                ],
            ],
        ]);

        try {
            DB::connection()->getPdo();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
