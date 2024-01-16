<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\DocumentRequest;
use App\Models\Documents;
use App\Models\User;

class DocumentsController extends Controller
{
    public function index(): Response | RedirectResponse
    {
        // $user = User::find(auth()->user()->id);
        $documents = User::find(auth()->user()->id)->getForm()->first()->documents();
        if (!$documents->get()->isNotEmpty()) {
            $documents->create();
        }
        return Inertia::render('Documents/Index', [
            'documents' => $documents->first()
        ]);
    }

    public function update(DocumentRequest $request): RedirectResponse
    {

        $documents = User::find(auth()->user()->id)->getForm()->first()->documents();
        // $documents->update($request->validated());

        $documents->update([
            $request->name => $request->file('file')->storePublicly('documents', 'public')
        ]);



        return Redirect::route('documents.index');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = User::find(auth()->user()->id);
        if (!$user->getForm()->get()->isNotEmpty() || !$user->getForm()->first()->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        $documents = $user->getForm()->first()->documents();
        $documents->update([
            $request->name => null
        ]);

        return Redirect::route('documents.index');
    }
}
