<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\DocumentRequest;
use App\Models\User;

class DocumentsController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        $form = auth()->user()->getForm;
        return Inertia::render('Documents/Index', [
            'ktp' => $form->getFirstMedia('ktp')?->getUrl() ?? null,
            'foto' => $form->getFirstMedia('foto')?->getUrl() ?? null,
            'ijazah' => $form->getFirstMedia('ijazah')?->getUrl() ?? null,
            'transkrip_nilai' => $form->getFirstMedia('transkrip_nilai')?->getUrl() ?? null,
        ]);
    }

    public function update(DocumentRequest $request): RedirectResponse
    {
        $form = auth()->user()->getForm;
        if ($request->hasFile('ktp') && $request->file('ktp')->isValid()) {
            $form->addMedia($request->file('ktp'))->toMediaCollection('ktp');
        }

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $form->addMedia($request->file('foto'))->toMediaCollection('foto');
        }

        if ($request->hasFile('ijazah') && $request->file('ijazah')->isValid()) {
            $form->addMedia($request->file('ijazah'))->toMediaCollection('ijazah');
        }

        if ($request->hasFile('transkrip_nilai') && $request->file('transkrip_nilai')->isValid()) {
            $form->addMedia($request->file('transkrip_nilai'))->toMediaCollection('transkrip_nilai');
        }

        return Redirect::route('documents.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->getForm || !$user->getForm->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        $documents = $user->getForm->documents;
        $documents->update([
            $request->name => null
        ]);

        return Redirect::route('documents.index');
    }
}
