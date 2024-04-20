<?php

namespace SoftWorksPy\AppConfig\Middlewares;

use Closure;
use Illuminate\Support\Str;
use SoftWorksPy\AppConfig\Models\Settings;
use SoftWorksPy\AppConfig\Models\Application;
use SoftWorksPy\AppConfig\Api\SimpleResponse;

class AuthorizationControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {

            \Event::fire('api.beforeRoute', [], true);

            if ($request->hasHeader('Agent')) {
                $userAgent = $request->header('Agent');
            } else {
                $userAgent = $request->header('User-Agent');
            }
            
            $authorization = $request->header('Authorization');
    
            if ($authorization && $userAgent) {
    
                if (Settings::get('enabled_authentication', false)) {
    
                    $class = Settings::get('class_authentication');
                    
                    if (!empty($class)) {
    
    
                        if (
                            Str::startsWith($authorization, 'Bearer')
                            && class_exists($class)
                        ) {
                            // call AuthenticationControl middleware
                            return app($class)->handle($request, $next);
                        }
                    }
                }
    
                list($appCode,) = explode('/', $userAgent);
                $application = Application::findByCode($appCode);
    
                if ($application) {
                    $authorized = $application->authCodes()
                        ->where('code', 'like', $authorization)
                        ->where('is_active', true)
                        ->count();
    
                    if ($authorized) return $next($request);
                }
            }
    
            return SimpleResponse::create('No tiene autorización para esta petición', 403);

        } catch (\Throwable $th) {
            
            return SimpleResponse::create($th->getMessage(), 405);
        }
    }
}
