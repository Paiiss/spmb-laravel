<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Form;

class AdminEndValidation extends Controller
{
    public function index(): Response
    {
        $data = Form::where('end_status', 'submitted')->orderBy('created_at', 'desc')->with('user', 'prodi', 'wave')->paginate(10)->through(function ($form) {
            return [
                'id' => $form->id,
                'user' => $form->user->name,
                'email' => $form->user->email,
                'phone' => $form->user->phone,
                'status' => $form->status,
                'end_status' => $form->end_status,
                'prodi' => $form->prodi->nama_prodi,
                'wave' => $form->wave->nama_wave,
            ];
        });

        return Inertia::render(
            'Admin/Verification/End/Index',
            [
                'forms' => $data
            ]
        );
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
