<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\WebSettingsRequest;
use App\Models\WebSettings;

class WebSettingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/WebSetting', [
            'webSettings' => WebSettings::first()
        ]);
    }

    public function update(WebSettingsRequest $request): RedirectResponse
    {
        $webSettings = WebSettings::first();

        $webSettings->update($request->validated());

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil menyimpan data'
        ]);

        return redirect()->back();
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
