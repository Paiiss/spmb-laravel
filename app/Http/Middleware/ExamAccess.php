<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\RedirectResponse;

class ExamAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $id): Response|RedirectResponse
    {
        $prodi = $request->user()->getForm->prodi;
        if ($prodi[$id] === 1) {
            return $next($request);
        }

        return redirect()->route('form.submission');
    }
}
