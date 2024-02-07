<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wave;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class WaveController extends Controller
{
    public function index(): Response
    {
        $wave = Wave::all();
        return Inertia::render('Admin/Wave', [
            'wave' => $wave
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'gelombang' => 'required|string|max:255',
            'tahun_akademik' => 'required|string|max:255',
            'awal_daftar' => 'required|date',
            'akhir_daftar' => 'required|date',
            'tes_tulis' => 'required|date',
            'tes_kesehatan' => 'required|date',
            'wawancara' => 'required|date',
            'active' => 'required|boolean'
        ]);

        Wave::create([
            'code' => $request->code,
            'gelombang' => $request->gelombang,
            'tahun_akademik' => $request->tahun_akademik,
            'awal_daftar' => $request->awal_daftar,
            'akhir_daftar' => $request->akhir_daftar,
            'tes_tulis' => $request->tes_tulis,
            'tes_kesehatan' => $request->tes_kesehatan,
            'wawancara' => $request->wawancara,
            'active' => $request->active
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'gelombang' => 'required|string|max:255',
            'tahun_akademik' => 'required|string|max:255',
            'awal_daftar' => 'required|date',
            'akhir_daftar' => 'required|date',
            'tes_tulis' => 'required|date',
            'tes_kesehatan' => 'required|date',
            'wawancara' => 'required|date',
            'active' => 'required|boolean'
        ]);

        Wave::where('id', $id)->update([
            'code' => $request->code,
            'gelombang' => $request->gelombang,
            'tahun_akademik' => $request->tahun_akademik,
            'awal_daftar' => $request->awal_daftar,
            'akhir_daftar' => $request->akhir_daftar,
            'tes_tulis' => $request->tes_tulis,
            'tes_kesehatan' => $request->tes_kesehatan,
            'wawancara' => $request->wawancara,
            'active' => $request->active
        ]);

        return Redirect::back();
    }

    public function destroy($id): RedirectResponse
    {
        Wave::where('id', $id)->delete();
        return Redirect::back();
    }
}
