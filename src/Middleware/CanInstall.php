<?php

namespace Codemen\Installer\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CanInstall
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->alreadyInstalled() === true) {
            $installedRedirect = config('installer.installedAlreadyAction');

            switch ($installedRedirect) {

                case 'route':
                    $routeName = config('installer.installed.redirectOptions.route.name');
                    $data = config('installer.installed.redirectOptions.route.parameters');

                    return redirect()->route($routeName)->with(['data' => $data]);
                    break;

                case 'abort':
                    abort(config('installer.installed.redirectOptions.abort.type'));
                    break;

                default:
                    abort(404);
            }
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        return env('APP_INSTALLED', false);
    }
}
