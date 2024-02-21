<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Health;
use Illuminate\Http\RedirectResponse;
use App\Helper\StatusHelper;
use App\Notifications\Candidate;

class HealthVerificationController extends Controller
{
    public function index(Request $request): Response
    {
        $health = Health::where('status', 'submitted')->orderBy('created_at', 'desc')->with('user')->paginate(10)->through(function ($health) {
            return [
                'id' => $health->id,
                'user' => $health->user->name,
                'email' => $health->user->email,
                'phone' => $health->user->phone,
                'height' => $health->height,
                'weight' => $health->weight,
                'blood_type' => $health->blood_type,
                'blood_pressure' => $health->blood_pressure,
                'blood_sugar' => $health->blood_sugar,
                'is_smoking' => $health->is_smoking == 1 ? 'Ya' : 'Tidak',
                'color_blind' => $health->color_blind == 1 ? 'Ya' : 'Tidak',
                'is_disability' => $health->is_disability == 1 ? 'Ya' : 'Tidak',
                'note' => $health->note,
                'status' => $health->status,
                'admin_note' => $health->admin_note,
                'created_at' => $health->created_at,
                'image' => $health->getFirstMediaUrl('image'),
            ];
        });
        return Inertia::render('Admin/Verification/Health/Index', [
            'health' => $health
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $health = Health::with('user')->find($id);
        $health->status = $request->status;
        $health->admin_note = $request->admin_note;
        // dd(StatusHelper::getStatus($health->status));
        $health->save();

        if ($health->status == 'approved' || $health->status == 'rejected') {
            $health->user->notify(new Candidate('Medical Check Up', StatusHelper::getStatus($health->status)));
        }
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Data berhasil diupdate'
        ]);
        return redirect()->back();
    }
}
