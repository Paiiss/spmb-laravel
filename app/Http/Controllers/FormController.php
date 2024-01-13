<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Wave;
use App\Http\Requests\FormUpdateRequest;
use Illuminate\Support\Facades\Redirect;

class FormController extends Controller
{
    public function edit(Request $request, string $id): Response | RedirectResponse
    {
        if (!(!$id || $id == "personal" || $id == 'disability' || $id == 'education' || $id == 'parent')) {
            return abort(404);
        }

        $user = $user = User::find(auth()->user()->id);
        if (!$user->getForm()->get()->isNotEmpty() || !$user->getForm()->first()->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        return Inertia::render('Form/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form' => $user->getForm,
            'id' => $id
        ]);
    }

    public function getForm(Request $request): Response
    {
        return Inertia::render('Form/GetForm', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function update(FormUpdateRequest $request): RedirectResponse
    {

        $user = User::find(auth()->user()->id);
        if (!$user->getForm()->get()->isNotEmpty() || !$user->getForm()->first()->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        $user->getForm()->update($request->validated());
        return Redirect::back();
    }

    public function submission(): Response
    {
        $user = User::find(auth()->user()->id);;
        return Inertia::render('Form/Submission', [
            'wave' => null,
            'form_status' => $user->getForm()->get()->isNotEmpty(),
            'amount' => $user?->getProdi()->biaya_registrasi ?? 0,
            'is_paid_registration' => $user->getForm()->first()->is_paid_registration ?? false,
        ]);
    }

    public function submissionStore(Request $request): RedirectResponse
    {
        //  input menggunakan id table
        $request->validate([
            'wave' => 'required|numeric',
            'option' => 'required|numeric',
            'option_2' => 'numeric|nullable',
        ]);
        $user = User::find(auth()->user()->id);

        if ($user->getForm()->get()->isNotEmpty()) {
            return Redirect::back()->withErrors(['form' => 'Anda sudah mengisi form']);
        }

        if (!Wave::getActiveDataById($request->wave)) {
            return Redirect::back()->withErrors(['wave' => 'Pilihan gelombang tidak tersedia']);
        }

        if (!Prodi::getProdiById($request->option)) {
            return Redirect::back()->withErrors(['option' => 'Pilihan prodi tidak tersedia']);
        }

        if ($request->option_2 && !Prodi::getProdiById($request->option_2)) {
            return Redirect::back()->withErrors(['option_2' => 'Pilihan prodi tidak tersedia']);
        }

        if (!$user->getForm()->get()->isNotEmpty()) {
            $user->getForm()->create();
        }

        $user->getForm()->update([
            'wave_id' => $request->wave,
            'option_id' => $request->option,
            'option_2_id' => $request->option_2 ?? null,
            'code_registration' => rand(1000, 9999),
        ]);

        return Redirect::route('form.submission');
    }

    public function payment(Request $request): Response
    {
        return Inertia::render(
            'Form/Payment',
            [
                'payment' => $request->user()->payments()->get(),
            ]
        );
    }
}
