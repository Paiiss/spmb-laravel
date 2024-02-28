<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PaymentRequest;
use App\Notifications\Candidate;

class AdminPaymentController extends Controller
{
    public function index(): Response
    {
        $payment = Payment::with('user', 'media')->orderBy('created_at', 'desc')->paginate(10)->through(function ($item) {
            return [
                'id' => $item->id,
                'bank' => $item->bank,
                'account_name' => $item->account_name,
                'account_number' => $item->account_number,
                'amount' => $item->amount,
                'date' => $item->date,
                'image' => $item->getFirstMediaUrl('image') ?? '',
                'type_payment' => $item->type_payment,
                'code' => $item->code,
                'status' => $item->status,
                'note' => $item->note,
                'user' => $item->user->name,
                'prodi' => $item->user->getForm->prodi->only('nama_prodi', 'biaya_registrasi', 'jenjang', 'fakultas') ?? 'Belum diisi',
            ];
        });
        return Inertia::render('Admin/Payment', [
            'payment' => $payment
        ]);
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
                    'Pembayaran',
                    'Selamat, pembayaran pendaftaran Anda telah diterima. Silahkan lengkapi data diri Anda untuk melanjutkan proses pendaftaran.'
                )
            );
        } else {
            if ($request->status === 'rejected' && $payment->type_payment == 'form') {
                $user->notify(
                    new Candidate(
                        'Pembayaran',
                        'Maaf, pembayaran pendaftaran Anda ditolak. Silahkan upload ulang bukti pembayaran.'
                    )
                );
            }

            $form->is_paid_registration = null;
        }
        $form->save();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Pembayaran berhasil diubah'
        ]);

        return Redirect::back();
    }

    public function destroy(string $id): RedirectResponse
    {
        $payment = Payment::find($id);
        $payment->delete();
        return Redirect::back();
    }
}
