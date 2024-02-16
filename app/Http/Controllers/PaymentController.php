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

    public function store(PaymentRequest $request): RedirectResponse
    {
        $request->validated();
        $payment = User::find(auth()->user()->id)->payments()->create(
            [
                'bank' => $request->bank,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'amount' => $request->amount,
                'date' => $request->date,
                // 'image' => $imagePath,
                'type_payment' => $request->type_payment,
                'code' => $request->code,
            ]
        );

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $payment->addMedia($request->file('image'))->toMediaCollection('image');
            // mengapa gagal mengupload
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Pembayaran berhasil diupload'
        ]);

        return Redirect::back();
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
