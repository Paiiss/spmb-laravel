<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ExamsRequest;


class ExamsController extends Controller
{
    public function index(): Response
    {
        $exams = Exams::all();
        return Inertia::render('Admin/Exams/Index', [
            'exams' => $exams,
        ]);
    }
    public function store(ExamsRequest $request): RedirectResponse
    {
        $exam = Exams::create($request->validated());
        return Redirect::back();
    }

    public function update(ExamsRequest $request): RedirectResponse
    {
        $exam = Exams::find($request->id);
        if (!$exam) {
            return Redirect::route('exams.index');
        }
        $exam->update($request->validated());
        return Redirect::back();
    }

    public function destroy(Request $request): RedirectResponse
    {
        $exam = Exams::find($request->id);
        if (!$exam) {
            return Redirect::back();
        }
        $exam->delete();
        return Redirect::back();
    }
}
