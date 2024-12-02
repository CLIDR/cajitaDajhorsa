<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

class ApplyTenantScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(Filament::getTenant());
        User::addGlobalScope(
            fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant()),
        );

        return $next($request);
    }
}
