<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Form;
use App\Models\Health;
use App\Models\ExamHistory;
use App\Http\Resources\ApiResource;
use Illuminate\Http\RedirectResponse;
use App\Notifications\Candidate;


class AdminEndValidation extends Controller
{
    public function index(): Response
    {
        $data = Form::where('end_status', 'submitted')->orderBy('created_at', 'desc')->with('user', 'prodi', 'wave')->paginate(10)->through(function ($form) {
            return [
                'id' => $form->id,
                'name' => $form->user->name,
                'email' => $form->user->email,
                'phone' => $form->user->phone,
                'status' => $form->status,
                'no_exam' => $form->no_exam,
                'end_status' => $form->end_status,
                'prodi' => $form->prodi->nama_prodi,
                'wave' => $form->wave->code,
            ];
        });

        return Inertia::render(
            'Admin/Verification/End/Index',
            [
                'forms' => $data
            ]
        );
    }

    public function show(Request $request, string $id)
    {
        $form = Form::where('id', $id)->with('user', 'prodi', 'wave')->first();
        $health = Health::where('user_id', $form->user->id)->first();
        $exam = ExamHistory::where('user_id', $form->user->id)->with('exam')->get()->toArray();
        $interview = $form->user->getInterviews;
        $data = [
            'health' => $health,
            'exam' => $exam,
            'interview' => $interview,
            'prodi' => $form->prodi,
            'form' => [
                'id' => $form->id,
                'name' => $form->user->name,
                'email' => $form->user->email,
                'phone' => $form->user->phone,
                'status' => $form?->status ?? null,
                'no_exam' => $form?->no_exam ?? null,
                'end_status' => $form?->end_status ?? null,
                'wave' => $form->wave?->code ?? null,
                'grade' => $form->education_grade ?? 0,
            ],
        ];
        return new ApiResource(200, 'OK', $data);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'reason' => ['required_if:status,rejected', 'nullable']
        ]);

        $form = Form::find($id);
        if (!$form) {
            return redirect()->back();
        }
        $form->end_status = $request->status;
        $form->reason_rejected = $request->reason;
        $form->save();

        $form->user->notify(
            new Candidate(
                'Pendaftaran',
                'Hasil akhir anda telah keluar, silahkan cek status pendaftaran anda.'
            )
        );


        return redirect()->back();
    }
}
