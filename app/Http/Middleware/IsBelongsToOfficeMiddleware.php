<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsBelongsToOfficeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rolesDependsOnOffice = [
            'site_supervisor',
            'subsidiary_receiving_committee_president',
            'assistant_subsidiary_receiving_committee_president',
            'subsidiary_receiving_committee_member',
        ];
        if (in_array(auth()->role->name, $rolesDependsOnOffice)) {
            $office = auth()->user->office;
            if ($request->office && $office->id !== $request->office->id) {
                abort(403);
            }
        }
        return $next($request);
    }
}
