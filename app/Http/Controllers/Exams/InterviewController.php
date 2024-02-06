<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Interviews;
use App\Models\User;

class InterviewController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();
        $interview = $user->getInterviews;
        if (!$interview) {
            $interview = Interviews::create([
                'user_id' => $user->id,
                'no_exam' => $user->getForm->no_exam,
                'status' => 'pending'
            ]);
        }
        if ($interview->verificator_id) {
            $interview->interviewed_by = User::find($interview->verificator_id)->name;
        }
        return Inertia::render('Exams/Interview/Index', [
            'interview' => $interview,
        ]);
    }

}
