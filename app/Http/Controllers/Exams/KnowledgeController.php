<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Exams;
use App\Models\ExamHistory;

class KnowledgeController extends Controller
{
    public function index(): Response|RedirectResponse
    {
        $user = auth()->user();
        $programstudi = $user->getForm->prodi;
        if (!$programstudi->tes_ujian)
            return redirect()->route('dashboard');

        $ujian = [];
        $perlu_ujian = ($user->getForm->education_grade ?? 0) < $programstudi->nilai_dibawah;

        if ($perlu_ujian) {
            $ujian = Exams::whereIn('id', explode(',', $programstudi->ujian))->where('is_active', 1)->withCount('questions')->get()->map(function ($item) {
                $history = $item->getHistoryByUser(auth()->user()->id);
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'duration' => $item['duration'],
                    'access_start_time' => $item['access_start_time'],
                    'access_end_time' => $item['access_end_time'],
                    'questions_count' => $item['questions_count'],
                    'can_start' => $item->canStartExams() && !$history?->is_submitted,
                    'is_active' => $history?->is_active,
                    'is_end' => $history?->is_finished || $history?->is_submitted,
                    'score' => $item['show_result'] ? $history?->score : null,
                ];
            });
        }
        ;

        return Inertia::render('Exams/Knowledge/Index', [
            'ujian' => $ujian,
            'perlu_ujian' => $perlu_ujian
        ]);
    }
    public function start(string $id): RedirectResponse|Response
    {
        try {

            $user = auth()->user();
            $programstudi = $user->getForm->prodi;
            if (!$programstudi->tes_ujian)
                throw new \Exception('Ujian tidak tersedia');
            if (!in_array($id, explode(',', $programstudi->ujian)))
                throw new \Exception('Ujian tidak tersedia');
            $exam = Exams::find($id);
            $userHistory = $exam->getHistoryByUser($user->id);
            if (!$exam->canStartExams() && now() > $userHistory?->finished_at)
                throw new \Exception('Ujian belum dimulai');
            if (!$exam)
                throw new \Exception('Ujian tidak tersedia');
            $question = $exam->questions;
            if ($question->count() < 1)
                throw new \Exception('Soal tidak tersedia');

            if ($userHistory && $userHistory?->finished_at && now() > $userHistory?->finished_at)
                throw new \Exception('Anda sudah pernah mengerjakan ujian ini');

            $order_questions = $exam->questions->pluck('id')->toArray();
            shuffle($order_questions);

            if (!$userHistory) {
                $userHistory = ExamHistory::create([
                    'user_id' => $user->id,
                    'exam_id' => $exam->id,
                    'is_active' => true,
                    'order_questions' => json_encode($order_questions),
                    'started_at' => now(),
                    'finished_at' => now()->addMinutes($exam->duration),
                ]);
            } else {
                $userHistory->update([
                    'is_active' => true,
                    'order_questions' => $order_questions,
                ]);
            }

            return redirect()->route('exams.knowledge.exams', $exam->id);
        } catch (\Throwable $th) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $th->getMessage() ?? 'Terjadi kesalahan saat memulai ujian',
            ]);

            return redirect()->route('exams.knowledge');
        }
    }

    public function exams(string $id)
    {
        try {
            $user = auth()->user();
            $exam = Exams::find($id);
            $userHistory = $exam->getHistoryByUser($user->id);
            if (!$exam->canStartExams() && now() > $userHistory?->finished_at)
                throw new \Exception('Ujian belum dimulai');
            if (!$exam)
                throw new \Exception('Ujian tidak tersedia');
            $question = $exam->questions;
            if ($question->count() < 1)
                throw new \Exception('Soal tidak tersedia');

            if (!$userHistory)
                throw new \Exception('Anda belum memulai ujian ini');

            if ($userHistory->is_submitted || $userHistory->is_finished)
                throw new \Exception('Anda sudah menyelesaikan ujian ' . $exam->name);

            if ($userHistory && $userHistory?->finished_at && now() > $userHistory?->finished_at)
                throw new \Exception('Anda sudah pernah mengerjakan ujian ini');

            return Inertia::render('Exams/Knowledge/Exams', [
                'exam' => $exam,
                'history' => $userHistory,
            ]);
        } catch (\Throwable $th) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $th->getMessage() ?? 'Terjadi kesalahan saat memulai ujian',
            ]);

            return redirect()->route('exams.knowledge');
        }
    }

    public function store(Request $request, string $id)
    {

        try {
            $user = auth()->user();

            $exam = Exams::find($id);
            $userHistory = $exam->getHistoryByUser($user->id);

            if (!$userHistory)
                throw new \Exception('Anda belum memulai ujian ini');

            if ($userHistory->is_submitted)
                throw new \Exception('Anda sudah menyelesaikan ujian ini');

            if ($userHistory && $userHistory?->finished_at && now() > $userHistory?->finished_at)
                throw new \Exception('Anda sudah pernah mengerjakan ujian ini');
            $request->validate([
                'answers' => 'required|array',
                'finish' => 'required|boolean',
            ]);

            $answer = $request->answers;
            $finish = $request->finish;
            $score = 0;

            if ($finish) {
                $poin = 0;
                foreach ($answer as $key => $answerPeserta) {
                    if (
                        $answerPeserta == $exam->questions->filter(function ($item) use ($key) {
                            return $item->id == $key;
                        })->first()?->answer
                    ) {
                        $poin += 1;
                    }
                }
                $score = $poin / $exam->questions->count() * 100;
            }

            ;
            $userHistory->update([
                'answers' => $answer,
                'is_submitted' => $finish,
                'is_finished' => $finish,
                'is_active' => !$finish,
                'score' => $score,
            ]);

            if (!$finish)
                return;
            return redirect()->route('exams.knowledge');
        } catch (\Throwable $th) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $th->getMessage() ?? 'Terjadi kesalahan saat memulai ujian',
            ]);

            return redirect()->route('exams.knowledge');
        }
    }
}
