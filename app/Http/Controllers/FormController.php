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
    public function edit(Request $request, string $id): Response|RedirectResponse
    {
        if (!(!$id || $id == "personal" || $id == 'address' || $id == 'disability' || $id == 'education' || $id == 'parent')) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Halaman tidak tersedia'
            ]);
            return Redirect::route('form.submission');
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

    public function update(FormUpdateRequest $request): RedirectResponse
    {
        $user = User::find(auth()->user()->id);
        if (!$user->getForm()->get()->isNotEmpty() || !$user->getForm()->first()->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        $form = $user->getForm();

        if ($form->first()->is_lock) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal menyimpan data, form anda sudah terkunci'
            ]);
            return Redirect::back();
        }

        $form->update($request->validated());
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil menyimpan data'
        ]);
        return Redirect::back();
    }

    public function submission(): Response
    {
        $user = $user = User::find(auth()->user()->id);
        $form = $user->getForm()->first();
        return Inertia::render('Form/Submission', [
            'wave' => $user?->getWave()?->first() ?? null,
            'form_status' => $user->getForm()->get()->isNotEmpty(),
            'amount' => $user?->getProdi()->biaya_registrasi ?? 0,
            'is_paid_registration' => $form->is_paid_registration ?? null,
            'code' => $form->code_registration ?? null,
            'percent' => $user->getProgress() ?? null,
            'is_lock' => $form->is_lock ?? false,
            'is_submitted' => $form->is_submitted ?? false,
        ]);
    }

    public function submissionStore(Request $request): RedirectResponse
    {
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

    public function validation(Request $request): RedirectResponse
    {

        $user = User::find(auth()->user()->id);
        $form = $user->getForm();

        if (!$form->get()->isNotEmpty()) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Anda belum memiliki form'
            ]);
            return Redirect::back();
        }

        if ($form->first()->is_lock) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Form anda sudah terkunci'
            ]);
            return Redirect::back();
        }

        $progress = $user->getProgress();

        $array = [
            'personal' => 'Data Pribadi',
            'address' => 'Data Alamat',
            'disability' => 'Data Disabilitas',
            'education' => 'Data Pendidikan',
            'parent' => 'Data Orang Tua',
            'document' => 'Dokumen',
        ];

        foreach ($progress as $key => $value) {
            if ($value < 100) {
                session()->flash('alert', [
                    'type' => 'danger',
                    'message' => 'Mohon lengkapi ' . $array[$key] . ' terlebih dahulu'
                ]);
                return Redirect::back();
            }
        }

        $form->update([
            'is_lock' => true,
            'is_submitted' => true,
            'status' => 'pending',
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Menunggu verifikasi admin'
        ]);

        return Redirect::back();
    }
}
