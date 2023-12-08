<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function allUser(): Response
    {
        $users = User::all();
        return Inertia::render("Admin/User", [
            // "users" => $users
        ]);
    }
}
