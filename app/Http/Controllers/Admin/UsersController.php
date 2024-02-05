<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller
{
    public function view(): Response
    {
        return Inertia::render("Admin/User", [
            "users" => User::paginate(10)
        ]);
    }

    public function search(string $search)
    {
        $users = User::where("name", "LIKE", "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%")->paginate(10);
        return response()->json($users);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        try {
            //code...
            $request->validate([
                "name" => "required",
                "email" => "required|email",
                "phone" => "nullable|string",
                "roles" => "required|array",
                'roles.*' => 'required|in:admin,user,keuangan,panitia',
                "is_Banned" => "nullable|boolean",
            ]);
            $user = User::find($id);
            if (!$user)
                throw new \Exception("User tidak ditemukan");
            $user->update([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "roles" => $request->roles,
                "is_Banned" => $request->is_Banned == 1 ? true : false,
            ]);

            session()->flash('alert', [
                "type" => "success",
                "message" => "Berhasil mengubah data user"
            ]);

            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('alert', [
                "type" => "danger",
                "message" => $th->getMessage() ?? "Terjadi kesalahan, silahkan coba lagi"
            ]);
            return redirect()->back();
        }
    }

    public function destroy($id): Response
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back();
    }
}
