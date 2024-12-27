<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundOnDenied
{
    public function handle(Request $request, Closure $next, $ability, $model = null)
    {
        if (is_string($model)) {
            $model = $model::find($request->route($model)) ?? $model;
        }

        if (Gate::denies($ability, $model)) {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
