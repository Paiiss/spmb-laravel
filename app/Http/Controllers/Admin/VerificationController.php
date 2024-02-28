<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Form;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Wave;
use App\Helper\StatusHelper;
use App\Notifications\Candidate;

class VerificationController extends Controller
{
    public function view(): Response
    {
        $form = Form::where('status', 'submitted')->orderBy('created_at', 'desc')->with('user', 'prodi')->paginate(10)->through(function ($form) {
            return [
                'id' => $form->id,
                'user' => $form->user,
                'no_exam' => $form->no_exam,
                'code_registration' => $form->code_registration,
                'wave_id' => $form->wave_id,
                'option' => $form->prodi,
                'is_submitted' => $form->is_submitted,
                'is_paid_registration' => $form->is_paid_registration,
                'status' => $form->status,
                'created_at' => $form->created_at,
                'updated_at' => $form->updated_at,
            ];
        });

        return Inertia::render('Admin/Verification/Index', [
            'forms' => $form
        ]);
    }

    public function index(string $id): Response|RedirectResponse
    {
        $form = Form::with('user', 'prodi', 'wave', 'media')->find($id);
        if (!$form) {
            return redirect()->route('admin.verification');
        }
        return Inertia::render('Admin/Verification/User', [
            'form' => $form,
            'user' => $form->user,
            'prodi' => $form->prodi,
            'wave' => $form->wave,
            'image' => [
                'ktp' => $form->getFirstMedia('ktp')?->getUrl() ?? null,
                'foto' => $form->getFirstMedia('foto')?->getUrl() ?? null,
                'ijazah' => $form->getFirstMedia('ijazah')?->getUrl() ?? null,
                'transkrip_nilai' => $form->getFirstMedia('transkrip_nilai')?->getUrl() ?? null,
            ]
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:approved,rejected'],
            'note' => ['nullable', 'string'],
            'is_via_online' => ['required', 'boolean'],
            'is_submitted' => ['required', 'boolean'],
        ]);

        $form = Form::with('user')->with('prodi')->with('wave')->find($id);

        if ($request->status == 'approved' && !$form->no_exam) {
            $form->no_exam = $form->wave->code . '-' . $form->prodi->id . '-' . $form->id;
        }
        $form->status = $request->status;
        $form->note = $request->note;
        $form->is_via_online = $request->is_via_online;
        if ($request->status !== 'approved')
            $form->is_lock = false;
        $form->is_submitted = $request->is_submitted;
        $form->save();

        $form->user->notify(
            new Candidate(
                'Pendaftaran',
                'Formulir anda ' . StatusHelper::getStatus($request->status) . ' oleh panitia'
            )
        );

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Formulir berhasil di ubah'
        ]);

        return redirect()->back();
    }
}
