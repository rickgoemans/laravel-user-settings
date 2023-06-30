<?php

namespace Rickgoemans\LaravelUserSettings\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rickgoemans\LaravelUserSettings\Services\UserSettingService;
use Symfony\Component\HttpFoundation\Response;

class MigrateUserSettings
{
    /** @param  Closure(Request): (Response)  $next */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            /** @var UserSettingService $service */
            $service = app(UserSettingService::class);

            $service->migrate();
        }

        return $next($request);
    }
}
