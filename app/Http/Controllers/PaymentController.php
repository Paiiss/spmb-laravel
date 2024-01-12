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

class PaymentController extends Controller
{
    public function index(): Response
    {
        $payment = Payment::all();
        return Inertia::render('Admin/Payment', [
            'payment' => $payment
        ]);
    }

    public function store(PaymentRequest $request): RedirectResponse
    {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $imagePath = 'images/' . $imageName;

        User::find(auth()->user()->id)->payments()->create(
            [
                'bank' => $request->bank,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'amount' => $request->amount,
                'date' => $request->date,
                'image' => $imagePath,
                'type_payment' => $request->type_payment,
            ]
        );
        // Payment::create($request->validated());

        return Redirect::back();
    }


    public function userDestroy(string $id): RedirectResponse
    {
        // $payment = Payment::find($id);
        $userPayment = User::find(auth()->user()->id)->payments()->where('id', $id)->first();
        if ($userPayment && $userPayment->status !== 'approved') {
            $userPayment->delete();
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
