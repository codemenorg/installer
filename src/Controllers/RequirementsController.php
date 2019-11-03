<?php

namespace Codemen\Installer\Controllers;

use Codemen\Installer\Services\RequirementService;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class RequirementsController extends Controller
{
    /**
     * @var RequirementService
     */
    private $requirementService;

    /**
     * @param RequirementService $requirementService
     */
    public function __construct(RequirementService $requirementService)
    {
        $this->requirementService = $requirementService;
    }

    /**
     * Display the requirements page.
     *
     * @param $type
     * @param $routeConfig
     * @return View
     */
    public function view($type, $routeConfig)
    {
        $phpSupportInfo = $this->requirementService->checkPHPversion(
            config('installer.core.minPhpVersion')
        );
        $requirements = $this->requirementService->check(
            config('installer.requirements')
        );

        $title = ucwords(str_replace('-', ' ', $type));

        return view('vendor.installer.requirements', compact(
            'requirements',
            'phpSupportInfo',
            'type',
            'routeConfig',
            'title'
        ));
    }
}
