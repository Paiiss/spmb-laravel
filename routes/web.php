<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\WaveController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\ExamQuesionController;
use App\Models\User;
use App\Models\Wave;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function (Request $request) {
    $user = User::find(auth()->user()->id);
    return Inertia::render('Dashboard', [
        'user' => $user,
        'isAdmin' => $request->user()->hasRole('admin'),
        'isAlreadyForm' => !$user->getForm()->get()->isEmpty(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/form/{id}', [FormController::class, 'edit'])->name('form.edit');
    Route::patch('/form', [FormController::class, 'update'])->name('form.update');
    Route::get('/submission', [FormController::class, 'submission'])->name('form.submission');
    Route::post('/submission', [FormController::class, 'submissionStore'])->name('form.submission.store');
    Route::get('/payment', [FormController::class, 'payment'])->name('form.payment');
    Route::post('/payment', [PaymentController::class, 'store'])->name('form.payment.store');
    Route::delete('/payment/{id}', [PaymentController::class, 'userDestroy'])->name('form.payment.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/user', [AdminController::class, 'allUser'])->name('admin.user');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/program-studi', [ProdiController::class, 'index'])->name('admin.prodi');
    Route::post('/admin/program-studi', [ProdiController::class, 'store'])->name('admin.prodi.store');
    Route::patch('/admin/program-studi/{id}', [ProdiController::class, 'update'])->name('admin.prodi.update');
    Route::delete('/admin/program-studi/{id}', [ProdiController::class, 'destroy'])->name('admin.prodi.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/wave', [WaveController::class, 'index'])->name('admin.wave');
    Route::post('/admin/wave', [WaveController::class, 'store'])->name('admin.wave.store');
    Route::patch('/admin/wave/{id}', [WaveController::class, 'update'])->name('admin.wave.update');
    Route::delete('/admin/wave/{id}', [WaveController::class, 'destroy'])->name('admin.wave.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/payment', [PaymentController::class, 'index'])->name('admin.payment');
    Route::patch('/admin/payment/{id}', [PaymentController::class, 'update'])->name('admin.payment.update');
    Route::delete('/admin/payment/{id}', [PaymentController::class, 'destroy'])->name('admin.payment.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/exams', [ExamsController::class, 'index'])->name('admin.exams');
    Route::post('/admin/exams', [ExamsController::class, 'store'])->name('admin.exams.store');
    Route::patch('/admin/exams/{id}', [ExamsController::class, 'update'])->name('admin.exams.update');
    Route::delete('/admin/exams/{id}', [ExamsController::class, 'destroy'])->name('admin.exams.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/exams/{exam_id}', [ExamQuesionController::class, 'index'])->name('admin.exams.questions');
    Route::post('/admin/exams/{exam_id}/questions', [ExamQuesionController::class, 'store'])->name('admin.exams.questions.store');
    Route::patch('/admin/exams/{exam_id}/questions/{question_id}', [ExamQuesionController::class, 'update'])->name('admin.exams.questions.update');
    Route::delete('/admin/exams/{exam_id}/questions/{question_id}', [ExamQuesionController::class, 'destroy'])->name('admin.exams.questions.destroy');
});


require __DIR__ . '/auth.php';
