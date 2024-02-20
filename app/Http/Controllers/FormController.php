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
use App\Models\Health;
use App\Models\ExamHistory;
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
                'end_status' => $form?->end_status ?? null,
                'is_paid_registration' => $form->is_paid_registration ?? null,
                'code' => $form->code_registration ?? null,
                'is_lock' => $form->is_lock ?? false,
                'is_submitted' => $form->is_submitted ?? false,
                'amount' => $form?->prodi->biaya_registrasi ?? 0,
                'foto' => $form->getFirstMedia('foto')?->getUrl() ?? null,
                'no_exam' => $form->no_exam ?? null,
                'reason_rejected' => $form->reason_rejected ?? null,
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

    public function submitFinalValidation(): RedirectResponse
    {
        try {
            $user = auth()->user();
            $form = $user->getForm->load('prodi', 'wave');

            if (!$form)
                throw new \Exception('Anda belum memiliki form');
            if ($form->end_status != 'pending')
                throw new \Exception('Anda tidak dapat lagi mengajukan');

            $prodi = $form->prodi;

            if ($prodi->tes_ujian && ($prodi->nilai_dibawah ?? 0) > $form->education_grade) {
                $result_knowledge = ExamHistory::where('user_id', $user->id)->with('exam')->get()->toArray();
                if (count($result_knowledge) < count(explode(',', $prodi->tes_ujian)))
                    throw new \Exception('Ada ujian yang belum diikuti');
            }

            if ($prodi->tes_kesehatan) {
                $result_health = Health::where('user_id', $user->id)->first();
                if (!$result_health)
                    throw new \Exception('Anda belum mengisi data kesehatan');
                if ($result_health->status != 'approved')
                    throw new \Exception('Data kesehatan anda tidak disetujui');
            }

            if ($prodi->tes_wawancara) {
                $result_interview = $user->getInterviews;

                if (!$result_interview)
                    throw new \Exception('Anda belum mengikuti wawancara');
                if ($result_interview->status != 'approved')
                    throw new \Exception('Anda tidak lulus wawancara');
            }


            $user->getForm()->update([
                'end_status' => 'submitted'
            ]);

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Berhasil mengajukan, tunggu verifikasi panitia'
            ]);
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $th->getMessage() ?? 'Terjadi kesalahan saat memulai ujian',
            ]);

            return redirect()->back();
        }
    }
}
