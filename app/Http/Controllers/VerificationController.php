<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Form;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Wave;

class VerificationController extends Controller
{
    public function view(): Response
    {

        $form = Form::where('is_submitted', true)->paginate(10)->through(function ($form) {
            // if ($form->is_submitted) 
            return [
                'id' => $form->id,
                'user' => User::where('id', $form->user_id)->first(),
                'no_exam' => $form->no_exam,
                'code_registration' => $form->code_registration,
                'wave_id' => $form->wave_id,
                'option' => Prodi::find($form->option_id)->first()->nama_prodi,
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

    public function index(String $id): Response | RedirectResponse
    {
        $form = Form::where('id', $id)->first();
        if (!$form) {
            return redirect()->route('admin.verification');
        }
        $user = User::where('id', $form->user_id)->first();
        $prodi = Prodi::where('id', $form->option_id)->first();
        $wave = Wave::where('id', $form->wave_id)->first();

        return Inertia::render('Admin/Verification/User', [
            'form' => $form,
            'user' => $user,
            'prodi' => $prodi,
            'wave' => $wave,
            'image' => [
                'ktp' => $form->getFirstMedia('ktp')?->getUrl() ?? null,
                'foto' => $form->getFirstMedia('foto')?->getUrl() ?? null,
                'ijazah' => $form->getFirstMedia('ijazah')?->getUrl() ?? null,
                'transkrip_nilai' => $form->getFirstMedia('transkrip_nilai')?->getUrl() ?? null,
            ]
        ]);
    }

    public function update(Request $request, String $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:waitting,pending,approved,rejected'],
            'note' => ['nullable', 'string'],
            'is_via_online' => ['required', 'boolean'],
            'is_lock' => ['required', 'boolean'],
            'is_submitted' => ['required', 'boolean'],
        ]);

        $form = Form::where('id', $id)->first();
        $user = User::where('id', $form->user_id)->first();
        $prodi = Prodi::find($form->option_id)->first();
        $wave = Wave::where('id', $form->wave_id)->first();

        if ($request->status == 'approved' && !$form->no_exam) {
            $form->no_exam = $wave->code . '-' . $prodi->id . '-' . $form->id;
        }
        $form->status = $request->status;
        $form->note = $request->note;
        $form->is_via_online = $request->is_via_online;
        $form->is_lock = $request->is_lock;
        $form->is_submitted = $request->is_submitted;
        $form->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Formulir berhasil di ubah'
        ]);

        return redirect()->back();
    }
}
