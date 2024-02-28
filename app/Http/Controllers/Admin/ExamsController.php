<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exams;
use App\Models\Prodi;
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
        $exams = Exams::paginate(5)->through(function ($exam) {
            return [
                'id' => $exam->id,
                'name' => $exam->name,
                'description' => $exam->description,
                'duration' => $exam->duration,
                'allowed' => $exam->allowed,
                'shuffle_question' => $exam->shuffle_question,
                'shuffle_answer' => $exam->shuffle_answer,
                'show_result' => $exam->show_result,
                'access_start_time' => $exam->access_start_time,
                'access_end_time' => $exam->access_end_time,
                'questions_count' => $exam->questions()->count(),
                'is_active' => $exam->is_active,
            ];
        });
        $prodi = Prodi::all();
        return Inertia::render('Admin/Exams/Index', [
            'exams' => $exams,
            'prodis' => $prodi,
        ]);
    }
    public function store(ExamsRequest $request): RedirectResponse
    {
        Exams::create($request->validated());
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
