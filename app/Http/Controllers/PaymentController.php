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
    public function index(): Response
    {
        // dd(rand(1000, 9999));
        $payment = Payment::all()->map(function ($payment) {
            return [
                ...$payment->toArray(),
                'image' => $payment->getFirstMediaUrl('image') ?? '',
            ];
        });
        return Inertia::render('Admin/Payment', [
            'payment' => $payment
        ]);
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
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Pembayaran berhasil diupload'
        ]);
        return Redirect::back();
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $payment = Payment::find($id);
        $payment->status = $request->status;
        $payment->note = $request->note ?? null;
        $payment->save();

        $user = User::find($payment->user_id);
        $form = $user->getForm;
        if ($request->status === 'approved' && $payment->type_payment == 'form') {
            $form->is_paid_registration = $payment->created_at;
            $user->notify(
                new Candidate(
                    'Pembayaran Pendaftaran Diterima',
                    'Selamat, pembayaran pendaftaran Anda telah diterima. Silahkan lengkapi data diri Anda untuk melanjutkan proses pendaftaran.'
                )
            );
        } else {
            $form->is_paid_registration = null;
        }
        $form->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Pembayaran berhasil diubah'
        ]);

        return Redirect::back();
    }


    public function userDestroy(string $id): RedirectResponse
    {
        // $payment = Payment::find($id);
        $userPayment = User::find(auth()->user()->id)->payments()->where('id', $id)->first();
        if ($userPayment && $userPayment->status !== 'approved') {
            $userPayment->delete();
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Pembayaran berhasil dihapus'
            ]);
        }
        return Redirect::back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $payment = Payment::find($id);
        $payment->delete();
        return Redirect::back();
    }
}
