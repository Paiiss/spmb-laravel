<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use App\Http\Requests\Exams\HealthRequest;

class HealthController extends Controller
{
    public function index(Request $reqeust): Response
    {
        $user = auth()->user()->health;
        if (!$user) {
            $user = auth()->user()->health()->create();
        }
        return Inertia::render('Exams/Health/Index', [
            'user' => $user,
            'image' => $user->getFirstMediaUrl('image') ?? null
        ]);
    }

    public function update(HealthRequest $request): RedirectResponse
    {
        $user = auth()->user()->health;

        if ($user->status == 'submitted') {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Anda sudah mengumpulkan!'
            ]);
            return redirect()->back();
        }
        $request->validated();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $user->addMedia($request->file('image'))->toMediaCollection('image');
        }

        $user->update([
            'height' => $request->height,
            'weight' => $request->weight,
            'blood_type' => $request->blood_type,
            'blood_pressure' => $request->blood_pressure,
            'blood_sugar' => $request->blood_sugar,
            'is_smoking' => $request->is_smoking,
            'color_blind' => $request->color_blind,
            'is_disability' => $request->is_disability,
            'note' => $request->note,
            'status' => 'submitted',
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil menyimpan data'
        ]);
        return redirect()->route('exams.health');
    }
}
