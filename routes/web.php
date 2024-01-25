<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\WaveController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\ExamQuesionController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Exams\HealthController;
use App\Http\Controllers\Exams\KnowledgeController;
use App\Http\Controllers\Exams\InterviewController;

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
    Route::get('/submission', [FormController::class, 'submission'])->name('form.submission');
    Route::post('/submission', [FormController::class, 'submissionStore'])->name('form.submission.store');

    Route::get('/payment', [FormController::class, 'payment'])->name('form.payment');
    Route::post('/payment', [PaymentController::class, 'store'])->name('form.payment.store');
    Route::delete('/payment/{id}', [PaymentController::class, 'userDestroy'])->name('form.payment.destroy');
});

Route::middleware(['auth', 'verified', 'payform'])->prefix('/form')->name('form.')->group(function () {
    Route::get('/{id}', [FormController::class, 'edit'])->name('edit');
    Route::patch('/', [FormController::class, 'update'])->name('update');
    Route::post('/validation', [FormController::class, 'validation'])->name('validation');
});

Route::middleware(['auth', 'verified', 'payform'])->prefix('/documents')->name('documents.')->group(function () {
    Route::get('/', [DocumentsController::class, 'index'])->name('index');
    Route::post('/', [DocumentsController::class, 'update'])->name('update');
});

Route::middleware(['auth', 'verified', 'formapproved'])->prefix('/exams')->name('exams.')->group(function () {
    Route::get('/health', [HealthController::class, 'index'])->name('health');
    Route::post('/health', [HealthController::class, 'update'])->name('health.update');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/user', [AdminController::class, 'allUser'])->name('user');

    Route::get('/program-studi', [ProdiController::class, 'index'])->name('prodi');
    Route::post('/program-studi', [ProdiController::class, 'store'])->name('prodi.store');
    Route::patch('/program-studi/{id}', [ProdiController::class, 'update'])->name('prodi.update');
    Route::delete('/program-studi/{id}', [ProdiController::class, 'destroy'])->name('prodi.destroy');

    Route::get('/wave', [WaveController::class, 'index'])->name('wave');
    Route::post('/wave', [WaveController::class, 'store'])->name('wave.store');
    Route::patch('/wave/{id}', [WaveController::class, 'update'])->name('wave.update');
    Route::delete('/wave/{id}', [WaveController::class, 'destroy'])->name('wave.destroy');

    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
    Route::patch('/payment/{id}', [PaymentController::class, 'update'])->name('payment.update');
    Route::delete('/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');

    Route::get('/exams', [ExamsController::class, 'index'])->name('exams');
    Route::post('/exams', [ExamsController::class, 'store'])->name('exams.store');
    Route::patch('/exams/{id}', [ExamsController::class, 'update'])->name('exams.update');
    Route::delete('/exams/{id}', [ExamsController::class, 'destroy'])->name('exams.destroy');

    Route::get('/exams/{exam_id}', [ExamQuesionController::class, 'index'])->name('exams.questions');
    Route::post('/exams/{exam_id}/questions', [ExamQuesionController::class, 'store'])->name('exams.questions.store');
    Route::patch('/exams/{exam_id}/questions/{question_id}', [ExamQuesionController::class, 'update'])->name('exams.questions.update');
    Route::delete('/exams/{exam_id}/questions/{question_id}', [ExamQuesionController::class, 'destroy'])->name('exams.questions.destroy');

    Route::get('/web-setting', [WebSettingController::class, 'index'])->name('web-setting');
    Route::patch('/web-setting', [WebSettingController::class, 'backup'])->name('web-setting.backup');

    Route::get('/verification', [VerificationController::class, 'view'])->name('verification');
    Route::get('/verification/{id}', [VerificationController::class, 'index'])->name('verification.user');
    Route::patch('/verification/{id}', [VerificationController::class, 'update'])->name('verification.user.update');
});


require __DIR__ . '/auth.php';
