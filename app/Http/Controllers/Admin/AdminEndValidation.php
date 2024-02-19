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

class AdminEndValidation extends Controller
{
    public function index(): Response
    {
        $data = Form::where('end_status', 'pending')->orderBy('created_at', 'desc')->with('user', 'prodi', 'wave')->paginate(10)->through(function ($form) {
            return [
                'id' => $form->id,
                'user' => $form->user->name,
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

    public function show(string $id)
    {
        $form = Form::find($id)->with('user', 'prodi', 'wave')->first();
        $health = Health::where('user_id', $form->user->id)->first();
        $exam = ExamHistory::where('user_id', $form->user->id)->get()->toArray();
        $interview = $form->user->getInterviews;
        // dd($exam);
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
                'status' => $form->status,
                'no_exam' => $form->no_exam,
                'end_status' => $form->end_status,
                'wave' => $form->wave->code,
            ],
        ];
        return new ApiResource(200, 'OK', $data);
    }

    public function update(Request $request, string $id): Response
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
        ]);

        $form = Form::find($id);
        if (!$form) {
            return redirect()->back();
        }
        $form->end_status = $request->status;
        $form->save();

        return redirect()->back();
    }
}
