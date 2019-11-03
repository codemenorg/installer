<?php

namespace Codemen\Installer\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectIfNotInstalled
{
    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->alreadyInstalled() === true || $this->isInstallerRoute($request)) {
            return $next($request);
        }
        return redirect()->route('installer.index');

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


    /**
     * Handle an incoming request.
     * @param Request $request
     * @return boolean
     */
    private function isInstallerRoute($request)
    {
        return in_array($request->route()->getPrefix(), ['install']) ;
    }
}
