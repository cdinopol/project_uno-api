<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SelectServer
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
            $server = $request->route()[2]['game_server'];

            DB::purge('mysql');
            Config::set('database.connections.mysql.database', $server);
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return response('Server Not Found!', 404);
        }

        return $next($request);
    }
}
