<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class WebSettingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/WebSetting');
    }

    public function backup(): RedirectResponse
    {
        Artisan::call('backup:run');

        $output = Artisan::output();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Backup database berhasil dilakukan'
        ]);

        return redirect()->back();
    }
}
