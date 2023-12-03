<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User;
use App\Http\Requests\FormUpdateRequest;
use Illuminate\Support\Facades\Redirect;

class FormController extends Controller
{
    public function edit(Request $request): Response
    {
        $user = $user = User::find(auth()->user()->id);
        if ($user->getForm()->get()->isNotEmpty()) {
            $form = $user->getForm;
        } else {
            $form = $user->getForm()->create();
        }
        return Inertia::render('Form/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form' => $form,
        ]);
    }

    public function getForm(Request $request): Response
    {
        return Inertia::render('Form/GetForm', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function update(FormUpdateRequest $request): RedirectResponse
    {

        $user = User::find(auth()->user()->id);
        // Bagaimana membuat jika form tidak di temukan maka throw error ?
        if (!$user->getForm()->get()->isNotEmpty()) {
            $user->getForm()->create();
        }
        $user->getForm()->update($request->validated());
        return Redirect::route('form.edit');
    }
}
