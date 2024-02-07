<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ExamQuestionsRequest;

use App\Models\Exams;
use App\Models\ExamQuestion;

class ExamQuesionController extends Controller
{
    public function index(string $exam_id)
    {
        $exam = Exams::find($exam_id);
        if (!$exam) {
            return Redirect::route('admin.exams');
        }
        // dd($exam->questions());
        return Inertia::render('Admin/Exams/Questions', [
            'exam' => $exam,
            'questions' => $exam->questions()->paginate(10),
        ]);
    }

    public function store(ExamQuestionsRequest $request, string $exam_id): RedirectResponse
    {
        $exam = Exams::find($exam_id);
        if (!$exam) {
            return Redirect::route('admin.exams');
        }

        $exam->questions()->create($request->validated()); //ExamQuestion::create($request->validated());

        return Redirect::back();
    }

    public function update(ExamQuestionsRequest $request, string $exam_id, string $question_id): RedirectResponse
    {
        $question = ExamQuestion::find($question_id);
        if (!$question) {
            return Redirect::back();
        }

        $question->update($request->validated());
        return Redirect::back();
    }

    public function destroy(string $exam_id, string $question_id): RedirectResponse
    {
        $question = ExamQuestion::find($question_id);
        if (!$question) {
            return Redirect::back();
        }

        $question->delete();
        return Redirect::back();
    }
}
