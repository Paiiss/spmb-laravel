<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Form;

class AdminEndValidation extends Controller
{
    public function index(): Response
    {
        return Inertia::render(
            'Admin/Verification/End/Index',
            [
                'forms' => Form::orderBy('created_at', 'desc')->with('user', 'prodi', 'wave')->paginate(10)
            ]
        );
    }
}
