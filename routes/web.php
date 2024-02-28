<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\WaveController;
use App\Http\Controllers\Admin\ExamsController;
use App\Http\Controllers\Admin\ExamQuesionController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\Admin\HealthVerificationController;
use App\Http\Controllers\Admin\AdminInterviewController;
use App\Http\Controllers\Admin\AdminEndValidation;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\Exams\HealthController;
use App\Http\Controllers\Exams\KnowledgeController;
use App\Http\Controllers\Exams\InterviewController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
    ]);
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        if ($request->user()->hasAnyRole(['admin', 'panitia', 'keuangan'])) {
            return Inertia::render('Admin/Dashboard');
        }
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::patch('/notification/{id}', function ($id) {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return;
    })->name('notifications.read');

    Route::delete('/notification/{id}', function ($id) {
        auth()->user()->notifications()->where('id', $id)->delete();
        return;
    })->name('notifications.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/submission', [FormController::class, 'submission'])->name('form.submission');
    Route::post('/submission', [FormController::class, 'submissionStore'])->name('form.submission.store');
    Route::post('/submission-final', [FormController::class, 'submitFinalValidation'])->name('form.submission.final');

    Route::get('/payment', [PaymentController::class, 'index'])->name('form.payment');
    Route::post('/payment', [PaymentController::class, 'store'])->name('form.payment.store');
    Route::delete('/payment/{id}', [PaymentController::class, 'userDestroy'])->name('form.payment.destroy');

    Route::middleware(['payform'])->prefix('/form')->name('form.')->group(function () {
        Route::get('/print', [FormController::class, 'pdf'])->name('pdf-print');
        Route::get('/{id}', [FormController::class, 'edit'])->name('edit');
        Route::patch('/', [FormController::class, 'update'])->name('update');
        Route::post('/validation', [FormController::class, 'validation'])->name('validation');

    });

    Route::middleware(['payform'])->prefix('/documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentsController::class, 'index'])->name('index');
        Route::post('/', [DocumentsController::class, 'update'])->name('update');
    });

    Route::middleware(['formapproved'])->prefix('/exams')->name('exams.')->group(function () {
        Route::middleware(['examaccess:tes_kesehatan'])->group(function () {
            Route::get('/health', [HealthController::class, 'index'])->name('health');
            Route::post('/health', [HealthController::class, 'update'])->name('health.update');
        });

        Route::middleware(['examaccess:tes_ujian'])->group(function () {
            Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge');
            Route::get('/knowledge/{id}', [KnowledgeController::class, 'exams'])->name('knowledge.exams');
            Route::post('/knowledge/{id}', [KnowledgeController::class, 'start'])->name('knowledge.start');
            Route::patch('/knowledge/{id}', [KnowledgeController::class, 'store'])->name('knowledge.store');
        });

        Route::middleware(['examaccess:tes_wawancara'])->group(function () {
            Route::get('/interview', [InterviewController::class, 'index'])->name('interview');
        });

    });
});

Route::middleware(['auth', 'verified', "role:admin,panitia,keuangan"])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/dashboard-chart', [DashboardController::class, 'index'])->name('dashboard.chart');

    Route::middleware(['role:admin,panitia'])->group(function () {
        Route::get('/program-studi', [ProdiController::class, 'index'])->name('prodi');
        Route::post('/program-studi', [ProdiController::class, 'store'])->name('prodi.store');
        Route::patch('/program-studi/{id}', [ProdiController::class, 'update'])->name('prodi.update');
        Route::delete('/program-studi/{id}', [ProdiController::class, 'destroy'])->name('prodi.destroy');

        Route::get('/wave', [WaveController::class, 'index'])->name('wave');
        Route::post('/wave', [WaveController::class, 'store'])->name('wave.store');
        Route::patch('/wave/{id}', [WaveController::class, 'update'])->name('wave.update');
        Route::delete('/wave/{id}', [WaveController::class, 'destroy'])->name('wave.destroy');

        Route::get('/exams', [ExamsController::class, 'index'])->name('exams');
        Route::post('/exams', [ExamsController::class, 'store'])->name('exams.store');
        Route::patch('/exams/{id}', [ExamsController::class, 'update'])->name('exams.update');
        Route::delete('/exams/{id}', [ExamsController::class, 'destroy'])->name('exams.destroy');

        Route::get('/exams/{exam_id}', [ExamQuesionController::class, 'index'])->name('exams.questions');
        Route::post('/exams/{exam_id}/questions', [ExamQuesionController::class, 'store'])->name('exams.questions.store');
        Route::patch('/exams/{exam_id}/questions/{question_id}', [ExamQuesionController::class, 'update'])->name('exams.questions.update');
        Route::delete('/exams/{exam_id}/questions/{question_id}', [ExamQuesionController::class, 'destroy'])->name('exams.questions.destroy');


        Route::get('/verification', [VerificationController::class, 'view'])->name('verification');
        Route::get('/verification/{id}', [VerificationController::class, 'index'])->name('verification.user');
        Route::patch('/verification/{id}', [VerificationController::class, 'update'])->name('verification.user.update');

        Route::get('/health-verification', [HealthVerificationController::class, 'index'])->name('health-verification');
        Route::post('/health-verification/{id}', [HealthVerificationController::class, 'update'])->name('health-verification.update');

        Route::get('/interview', [AdminInterviewController::class, 'index'])->name('interview');
        Route::post('/interview/{id}', [AdminInterviewController::class, 'update'])->name('interview.update');
        Route::get('/interview/search/{search}', [AdminInterviewController::class, 'search'])->name('interview.search');

        Route::get('/end-validation', [AdminEndValidation::class, 'index'])->name('end-validation');
        Route::get('/end-validation/{id}', [AdminEndValidation::class, 'show'])->name('end-validation.show');
        Route::patch('/end-validation/{id}', [AdminEndValidation::class, 'update'])->name('end-validation.update');
    });

    Route::middleware(['role:keuangan,admin'])->group(function () {
        Route::get('/payment', [AdminPaymentController::class, 'index'])->name('payment');
        Route::patch('/payment/{id}', [AdminPaymentController::class, 'update'])->name('payment.update');
        Route::delete('/payment/{id}', [AdminPaymentController::class, 'destroy'])->name('payment.destroy');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/user', [UsersController::class, 'view'])->name('user');
        Route::get('/user/search/{search}', [UsersController::class, 'search'])->name('user.search');
        Route::patch('/user/{id}', [UsersController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UsersController::class, 'destroy'])->name('user.destroy');

        Route::get('/web-setting', [WebSettingController::class, 'index'])->name('web-setting');
        Route::patch('/web-setting/backup', [WebSettingController::class, 'backup'])->name('web-setting.backup');
        Route::patch('/web-setting', [WebSettingController::class, 'update'])->name('web-setting.update');
    });


});


require __DIR__ . '/auth.php';
