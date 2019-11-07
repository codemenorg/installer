<?php


namespace Codemen\Installer\Validators;


use Codemen\Installer\Requests\FormRequest;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseValidator extends Validator
{
    public function validate(FormRequest $request)
    {
        $config = $request->except('_token');

        Config::set('database.connections.install_test', [
            'host' => $config['db_host'],
            'port' => $config['db_port'],
            'database' => $config['db_database'],
            'username' => $config['db_username'],
            'password' => $config['db_password'],
            'driver' => $config['db_connection'],
        ]);

        try {
            DB::connection('install_test')->getPdo();
            DB::purge('install_test');
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'Invalid Database Configuration';
    }
}
