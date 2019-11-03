<?php


namespace Codemen\Installer\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseValidator
{
    public function validate(Request$request, $type)
    {
        $config = $request->except('_token');

        Config::set('database.connections.install_test', [
            'host'      => $config['db_host'],
            'port'      => $config['db_port'],
            'database'  => $config['db_database'],
            'username'  => $config['db_username'],
            'password'  => $config['db_password'],
            'driver'    => $config['db_connection'],
        ]);

        try {
            DB::connection('install_test')->getPdo();
        } catch (\Exception $e) {
            back()->withInput()->with('error', 'Invalid Database Configuration')->send();
        }
        // Purge test connection
        DB::purge('install_test');
    }
}
