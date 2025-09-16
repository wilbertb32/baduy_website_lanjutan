<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function update(Request $request, User $user)
    {
        // Opsional, karena sudah diproteksi middleware
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak dapat mengubah role superadmin.');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('admin_success', 'Role pengguna berhasil diperbarui.');
    }

    public function promoteToAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Superadmin tidak dapat diubah rolenya.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Pengguna ini sudah menjadi admin.');
        }

        $user->role = 'admin';
        $user->save();

        return back()->with('admin_success', 'Pengguna berhasil dijadikan admin.');
    }
}

