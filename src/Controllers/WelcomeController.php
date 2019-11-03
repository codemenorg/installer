<?php

namespace Codemen\Installer\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return Response
     */
    public function welcome()
    {
        $data['nextRoute'] = array_key_first(config('installer.routes'));
        return view('vendor.installer.index', $data);
    }
}
