<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Exams;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProdiController extends Controller
{
    public function index(): Response
    {
        $prodi = Prodi::all();
        return Inertia::render('Admin/Prodi', [
            'prodi' => $prodi,
            'knowledges' => Exams::activeExamSelect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'akreditasi' => 'required|string|max:255',
            'tes_ujian' => 'required|boolean',
            'ujian' => 'nullable|string|max:100',
            'tes_wawancara' => 'required|boolean',
            'tes_kesehatan' => 'required|boolean',
            'biaya_registrasi' => 'required|integer',
            'status' => 'boolean',
            'nilai_dibawah' => 'nullable|integer|min:0|max:100'
        ]);

        Prodi::create([
            'nama_prodi' => $request->nama_prodi,
            'jenjang' => $request->jenjang,
            'fakultas' => $request->fakultas,
            'akreditasi' => $request->akreditasi,
            'tes_ujian' => $request->tes_ujian,
            'ujian' => $request->ujian,
            'tes_wawancara' => $request->tes_wawancara,
            'tes_kesehatan' => $request->tes_kesehatan,
            'biaya_registrasi' => $request->biaya_registrasi,
            'status' => $request->status ?? false,
            'nilai_dibawah' => $request->nilai_dibawah ?? 0
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'akreditasi' => 'required|string|max:255',
            'tes_ujian' => 'required|boolean',
            'ujian' => 'nullable|string|max:100',
            'tes_wawancara' => 'required|boolean',
            'tes_kesehatan' => 'required|boolean',
            'biaya_registrasi' => 'required|integer',
            'status' => 'boolean',
            'nilai_dibawah' => 'nullable|integer|min:0|max:100'
        ]);

        Prodi::where('id', $id)->update([
            'nama_prodi' => $request->nama_prodi,
            'jenjang' => $request->jenjang,
            'fakultas' => $request->fakultas,
            'akreditasi' => $request->akreditasi,
            'tes_ujian' => $request->tes_ujian,
            'ujian' => $request->ujian,
            'tes_wawancara' => $request->tes_wawancara,
            'tes_kesehatan' => $request->tes_kesehatan,
            'biaya_registrasi' => $request->biaya_registrasi,
            'status' => $request->status ?? false,
            'nilai_dibawah' => $request->nilai_dibawah ?? 0
        ]);

        return Redirect::back();
    }

    public function destroy($id): RedirectResponse
    {
        Prodi::where('id', $id)->delete();
        return Redirect::back();
    }
}
