<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Requests\FormRequest;
use Codemen\Installer\Services\DatabaseService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MigrationsController extends Controller
{
    /**
     * @var DatabaseService
     */
    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {

        $this->databaseService = $databaseService;
    }

    public function view($type, $routeConfig)
    {
        $title = __('Database Migrations');
        return view('vendor.installer.migrations',
            compact(
                'type',
                'routeConfig',
                'title'
            )
        );
    }

    public function store(FormRequest $request)
    {
        set_time_limit(120);
        $isRollback = false;
        if ($request->has('action')) {
            $response = $this->databaseService->rollback();
            $isRollback = true;
        } else {
            $response = $this->databaseService->migrate();
        }
        return redirect()->back()->with(compact('response', 'isRollback'));
    }
}
