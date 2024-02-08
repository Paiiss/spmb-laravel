<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Interviews;
use App\Notifications\Candidate;
use App\Helper\StatusHelper;

class AdminInterviewController extends Controller
{
    public function index(): Response
    {
        $interviews = Interviews::orderBy('created_at', 'desc')->with('user')->paginate(10);
        return Inertia::render('Admin/Verification/Interview/Index', [
            'interviews' => $interviews
        ]);
    }

    public function update(Request $request, $id)
    {
        $interview = Interviews::find($id);
        $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
            'interview_date' => ['nullable', 'date'],
            'note' => ['nullable', 'string']
        ]);
        $interview->status = $request->status;
        $interview->note = $request->note;
        $interview->interview_date = $request->interview_date;
        $interview->verified_by = json_encode([
            'id' => auth()->user()->id,
            'name' => auth()->user()->name
        ]);

        $interview->user->notify(new Candidate('Interview', StatusHelper::getStatus($interview->status)));
        // dd($interview->user);

        $interview->save();
        return redirect()->back();
    }

    public function search(Request $request, string $search)
    {
        $interviews = Interviews::where('user_id', 'like', '%' . $search . '%')
            ->orWhere('no_exam', 'like', '%' . $search . '%')
            ->orWhere('interview_date', 'like', '%' . $search . '%')
            ->orWhere('note', 'like', '%' . $search . '%')
            ->orWhere('verificator_id', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->with('user')
            ->paginate(10);
        return response()->json($interviews);
    }

    public function filter(Request $request)
    {
        $interviews = Interviews::where('status', $request->status)
            ->with('user')
            ->paginate(10);
        return Inertia::render('Admin/Verification/Interview/Index', [
            'interviews' => $interviews
        ]);
    }

    // public function export()
    // {
    //     return Excel::download(new InterviewsExport, 'interviews.xlsx');
    // }

}
