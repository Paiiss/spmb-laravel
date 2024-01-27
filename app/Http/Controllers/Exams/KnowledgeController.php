<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KnowledgeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Exams/Knowledge/Index');
    }
}
