<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $form = $user?->getForm ?? null;
        $prodi = $user?->getProdi ?? null;
        $exams = [
            'knowledge' => $prodi?->tes_ujian ?? null,
            'health' => $prodi?->tes_kesehatan ?? null,
            'interview' => $prodi?->tes_wawancara ?? null,
        ];
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'form' => [
                    'already' => $form ? true : false,
                    'status' => $form?->status ?? null,
                    'is_paid_registration' => $form?->is_paid_registration ?? null,
                ],
                'exams' => $exams,

            ],
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'alert' => $request->session()->get('alert'),
            ],
            'notifications' => $user?->notifications ?? null,
        ];
    }
}
