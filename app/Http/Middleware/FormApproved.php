<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $form = $request->user()->getForm()->first();
        if ($form && $form->get()->isNotEmpty() && $form['status'] == 'approved' && $form['is_paid_registration'] == 1) {
            return $next($request);
        }
        return $next($request);
    }
}
