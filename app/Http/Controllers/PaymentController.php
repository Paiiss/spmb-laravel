<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PaymentRequest;
use App\Notifications\Candidate;

class PaymentController extends Controller
{

    public function index(Request $request): Response
    {
        return Inertia::render(
            'Form/Payment',
            [
                'payment' => $request->user()->payments->map(function ($payment) {
                    return [
                        ...$payment->toArray(),
                        'image' => $payment->getFirstMediaUrl('image'),
                    ];
                }),
            ]
        );
    }

    public function userDestroy(string $id): RedirectResponse
    {
        // $payment = Payment::find($id);
        $userPayment = auth()->user()->id->payments()->where('id', $id)->first();
        if ($userPayment && $userPayment->status !== 'approved') {
            $userPayment->delete();
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Pembayaran berhasil dihapus'
            ]);
        }
        return Redirect::back();
    }
}
