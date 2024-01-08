<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
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
            'prodi' => $prodi
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'akreditasi' => 'required|string|max:255'
        ]);

        Prodi::create([

            'nama_prodi' => $request->nama_prodi,
            'jenjang' => $request->jenjang,
            'fakultas' => $request->fakultas,
            'akreditasi' => $request->akreditasi
        ]);

        return Redirect::back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'akreditasi' => 'required|string|max:255'
        ]);

        Prodi::where('id', $id)->update([
            'nama_prodi' => $request->nama_prodi,
            'jenjang' => $request->jenjang,
            'fakultas' => $request->fakultas,
            'akreditasi' => $request->akreditasi
        ]);

        return Redirect::back();
    }

    public function destroy($id): RedirectResponse
    {
        Prodi::where('id', $id)->delete();
        return Redirect::back();
    }
}
