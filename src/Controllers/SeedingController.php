<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Requests\FormRequest;
use Codemen\Installer\Services\DatabaseService;
use Illuminate\Routing\Controller;

class SeedingController extends Controller
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
        $title = __('Database Seeding');
        return view('vendor.installer.seeding',
            compact(
                'type',
                'routeConfig',
                'title',
                'response'
            )
        );
    }

    public function store(FormRequest $request)
    {
        set_time_limit(120);
        $response = $this->databaseService->seed();
        return redirect()->back()->with(compact('response', 'isRollback'));
    }
}
