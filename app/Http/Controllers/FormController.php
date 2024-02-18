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
            return redirect()->route('form.submission');
        }

        $user = auth()->user();
        if (!$user->getForm || !$user->getForm->is_paid_registration) {
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
        $user = auth()->user();
        if (!$user->getForm || !$user->getForm->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        $form = $user->getForm;

        if ($form->is_lock) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal menyimpan data, form anda sudah terkunci'
            ]);
            return Redirect::back();
        }

        $user->getForm()->update($request->validated());
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil menyimpan data'
        ]);
        return Redirect::back();
    }

    public function submission(): Response
    {
        $user = auth()->user();
        $form = $user->getForm;
        return Inertia::render('Submission/Index', [
            'form' => [
                'name' => $user?->name ?? null,
                'email' => $user?->email ?? null,
                'prodi' => $form?->prodi?->nama_prodi ?? null,
                'education_number' => $form?->education_number ?? null,
                'birth_date' => $form?->birth_date ?? null,
                'birth_place_city' => $form?->birth_place_city ?? null,
                'wave' => $form?->wave ?? null,
                'status' => $form?->status ?? null,
                'is_paid_registration' => $form->is_paid_registration ?? null,
                'code' => $form->code_registration ?? null,
                'is_lock' => $form->is_lock ?? false,
                'is_submitted' => $form->is_submitted ?? false,
                'amount' => $form?->prodi->biaya_registrasi ?? 0,
                'foto' => $form->getFirstMedia('foto')?->getUrl() ?? null,
                'no_exam' => $form->no_exam ?? null,
            ],
            'percent' => $user->getProgress() ?? null,
        ]);
    }

    public function submissionStore(Request $request): RedirectResponse
    {
        $request->validate([
            'wave' => 'required|numeric',
            'option' => 'required|numeric',
            'option_2' => 'numeric|nullable',
        ]);

        $user = auth()->user();

        if ($user->getForm) {
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

        if (!$user->getForm) {
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

    public function validation(Request $request): RedirectResponse
    {

        $user = auth()->user();
        $form = $user->getForm;

        if (!$form) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Anda belum memiliki form'
            ]);
            return Redirect::back();
        }

        if ($form->status == 'submitted' || $form->status == 'approved' || $form->status == 'pending') {
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

        $user->getForm()->update([
            'status' => 'submitted'
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Menunggu verifikasi admin'
        ]);

        return Redirect::back();
    }
}
