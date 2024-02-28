<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Wave;
use App\Models\Health;
use App\Models\ExamHistory;
use App\Http\Requests\FormUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyPdf;
use App\Models\WebSettings;

class FormController extends Controller
{
    public function edit(Request $request, string $id): Response|RedirectResponse
    {
        if (!(!$id || $id == "personal" || $id == 'address' || $id == 'disability' || $id == 'education' || $id == 'parent')) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Halaman tidak tersedia'
            ]);
            return redirect()->route('form.submission');
        }

        $user = auth()->user();
        if (!$user->getForm || !$user->getForm->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        return Inertia::render('Form/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form' => $user->getForm,
            'id' => $id
        ]);
    }

    public function update(FormUpdateRequest $request): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->getForm || !$user->getForm->is_paid_registration) {
            return Redirect::route('form.submission');
        }
        $form = $user->getForm;

        if ($form->is_lock) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Gagal menyimpan data, form anda sudah terkunci'
            ]);
            return Redirect::back();
        }

        $user->getForm()->update($request->validated());
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Berhasil menyimpan data'
        ]);
        return Redirect::back();
    }

    public function submission(): Response
    {
        $user = auth()->user();
        $form = $user->getForm;
        return Inertia::render('Submission/Index', [
            'form' => [
                'name' => $user?->name ?? null,
                'email' => $user?->email ?? null,
                'prodi' => $form?->prodi?->nama_prodi ?? null,
                'education_number' => $form?->education_number ?? null,
                'birth_date' => $form?->birth_date ?? null,
                'birth_place_city' => $form?->birth_place_city ?? null,
                'wave' => $form?->wave ?? null,
                'status' => $form?->status ?? null,
                'end_status' => $form?->end_status ?? null,
                'is_paid_registration' => $form->is_paid_registration ?? null,
                'code' => $form->code_registration ?? null,
                'is_lock' => $form->is_lock ?? false,
                'is_submitted' => $form->is_submitted ?? false,
                'amount' => $form?->prodi->biaya_registrasi ?? 0,
                'foto' => $form?->getFirstMedia('foto')?->getUrl() ?? null,
                'no_exam' => $form->no_exam ?? null,
                'note' => $form->note ?? null,
                'reason_rejected' => $form->reason_rejected ?? null,
            ],
            'percent' => $user->getProgress() ?? null,
        ]);
    }

    public function submissionStore(Request $request): RedirectResponse
    {
        $request->validate([
            'wave' => 'required|numeric',
            'option' => 'required|numeric',
            'option_2' => 'numeric|nullable',
        ]);

        $user = auth()->user();

        if ($user->getForm) {
            return Redirect::back()->withErrors(['form' => 'Anda sudah mengisi form']);
        }

        if (!Wave::getActiveDataById($request->wave)) {
            return Redirect::back()->withErrors(['wave' => 'Pilihan gelombang tidak tersedia']);
        }

        if (!Prodi::getProdiById($request->option)) {
            return Redirect::back()->withErrors(['option' => 'Pilihan prodi tidak tersedia']);
        }

        if ($request->option_2 && !Prodi::getProdiById($request->option_2)) {
            return Redirect::back()->withErrors(['option_2' => 'Pilihan prodi tidak tersedia']);
        }

        if (!$user->getForm) {
            $user->getForm()->create();
        }

        $user->getForm()->update([
            'wave_id' => $request->wave,
            'option_id' => $request->option,
            'option_2_id' => $request->option_2 ?? null,
            'code_registration' => rand(1000, 9999),
        ]);

        return Redirect::route('form.submission');
    }

    public function validation(Request $request): RedirectResponse
    {

        $user = auth()->user();
        $form = $user->getForm;

        if (!$form) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Anda belum memiliki form'
            ]);
            return Redirect::back();
        }

        if ($form->status == 'submitted' || $form->status == 'approved' || $form->status == 'pending') {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'Form anda sudah terkunci'
            ]);
            return Redirect::back();
        }

        $progress = $user->getProgress();

        $array = [
            'personal' => 'Data Pribadi',
            'address' => 'Data Alamat',
            'disability' => 'Data Disabilitas',
            'education' => 'Data Pendidikan',
            'parent' => 'Data Orang Tua',
            'document' => 'Dokumen',
        ];

        foreach ($progress as $key => $value) {
            if ($value < 100) {
                session()->flash('alert', [
                    'type' => 'danger',
                    'message' => 'Mohon lengkapi ' . $array[$key] . ' terlebih dahulu'
                ]);
                return Redirect::back();
            }
        }

        $user->getForm()->update([
            'status' => 'submitted',
            'is_lock' => true
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Menunggu verifikasi admin'
        ]);

        return Redirect::back();
    }

    public function submitFinalValidation(): RedirectResponse
    {
        try {
            $user = auth()->user();
            $form = $user->getForm->load('prodi', 'wave');

            if (!$form)
                throw new \Exception('Anda tidak memiliki form');
            if ($form->end_status != 'pending')
                throw new \Exception('Anda tidak dapat lagi mengajukan');

            $prodi = $form->prodi;

            if ($prodi->tes_ujian && ($prodi->nilai_dibawah ?? 0) > $form->education_grade) {
                $result_knowledge = ExamHistory::where('user_id', $user->id)->with('exam')->get()->toArray();
                if (count($result_knowledge) < count(explode(',', $prodi->tes_ujian)))
                    throw new \Exception('Ada ujian yang belum diikuti');
            }

            if ($prodi->tes_kesehatan) {
                $result_health = Health::where('user_id', $user->id)->first();
                if (!$result_health)
                    throw new \Exception('Anda belum melaksanakan tes kesehatan');
                if ($result_health->status != 'approved')
                    throw new \Exception('Data kesehatan anda tidak disetujui');
            }

            if ($prodi->tes_wawancara) {
                $result_interview = $user->getInterviews;

                if (!$result_interview)
                    throw new \Exception('Anda belum mengikuti wawancara');
                if ($result_interview->status != 'approved')
                    throw new \Exception('Anda tidak lulus wawancara');
            }


            $user->getForm()->update([
                'end_status' => 'submitted'
            ]);

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Berhasil mengajukan, tunggu verifikasi panitia'
            ]);
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $th->getMessage() ?? 'Terjadi kesalahan saat memulai ujian',
            ]);

            return redirect()->back();
        }
    }

    public function pdf()
    {
        try {
            $user = auth()->user();
            $form = $user->getForm;
            $wave = $form->wave;
            $core = WebSettings::first();

            if ($form->end_status != 'approved')
                throw new \Exception('Form anda belum disetujui');

            $pdf = new MyPdf('P', 'mm', 'A4');

            $pdf->skipFooter = true;
            $pdf->SetTitle('Pengumuman Hasil');
            $pdf->AddPage();
            $pdf->SetMargins(20, 10, 20);

            $pdf->SetFont('Times', 'BU', '14');
            $pdf->Cell(0, 20, strtoupper('Pengumuman Kelulusan'), 0, 1, 'C');
            $pdf->ln(5);

            $x = $pdf->GetX() + 10;
            $beetwen = 7;

            $pdf->SetFont('Times', '', '10');

            $pdf->SetX($x);
            $pdf->Cell(40, 10, 'Nama', 0, 0, 'L');
            $pdf->Cell(60, 10, ': ' . strtoupper($user->name), 0, 0, 'L');
            $pdf->ln($beetwen);

            $pdf->SetX($x);
            $pdf->Cell(40, 10, 'Program Studi', 0, 0, 'L');
            $pdf->Cell(60, 10, ': ' . strtoupper($form->prodi->jenjang . ' - ' . $form->prodi->nama_prodi), 0, 0, 'L');
            $pdf->ln($beetwen);

            $pdf->SetX($x);
            $pdf->Cell(40, 10, 'Gelombang', 0, 0, 'L');
            $pdf->Cell(60, 10, ': ' . strtoupper($wave->code . ' - ' . $wave->tahun_akademik), 0, 0, 'L');
            $pdf->ln($beetwen);

            $pdf->SetX($x);
            $pdf->Cell(40, 10, 'Nomor Pendaftaran', 0, 0, 'L');
            $pdf->Cell(60, 10, ': ' . $form->no_exam, 0, 0, 'L');

            $pdf->ln(25);

            $pdf->SetFont('Times', '', '10');
            $pdf->Cell(0, 10, 'Dengan ini diberitahukan bahwa peserta seleksi penerimaan mahasiswa baru telah dinyatakan ', 0, 1, 'C');


            $pdf->ln(5);
            $pdf->SetX(25);
            $pdf->SetFillColor(255);
            $pdf->SetFont('Arial', 'B', '20');
            $pdf->SetTextColor(0, 128, 0);
            $pdf->Cell(0, 20, 'LULUS', 1, 0, 'C', true);


            $pdf->ln(30);

            $beetwen_note = 5;
            $pdf->SetFont('Times', '', '10');
            $pdf->SetTextColor(0);
            $pdf->Cell(0, 10, 'Peserta yang dinyatakan lulus seleksi penerimaan mahasiswa baru diharapkan untuk segera melakukan ', 0, 0, 'L');
            $pdf->ln($beetwen_note);
            $pdf->Cell(0, 10, '1. Pembayaran registrasi mahasiswa baru yang dinyatakan lulus', 0, 0, 'L');
            $pdf->ln($beetwen_note);
            $pdf->Cell(0, 10, '2. Lakukan pembayaran mahasiwa baru ke ' . $core->payment_bank . ' - ' . $core->payment_name, 0, 0, 'L');
            $pdf->ln($beetwen_note);
            $pdf->Cell(0, 10, '3. Bagi mahasiswa baru yang telah melakukan pembayaran agar menyerahkan bukti pembayaran ke bagian keuangan ', 0, 0, 'L');
            $pdf->ln($beetwen_note);
            $pdf->SetX(23);
            $pdf->Cell(0, 10, $core->institution_name, 0, 0, 'L');
            $pdf->ln($beetwen_note);
            $pdf->Cell(0, 10, '4. Bagi mahasiswa baru yang tidak melakukan registrasi pada tanggal yang telah ditentukan dianggap mengundurkan diri ', 0, 0, 'L');


            $pdf->Output('hasil.pdf', "I");

            exit;
        } catch (\Throwable $th) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $th->getMessage() ?? 'Terjadi kesalahan saat membuat pdf',
            ]);

            return redirect()->route('form.submission');
        }
    }
}
