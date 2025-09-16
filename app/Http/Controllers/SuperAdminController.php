<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Carousel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get();
        $carousels = Carousel::with('images')->orderBy('order')->get();
        $users = User::all();
        
        // Ambil artikel berdasarkan status - SAMA SEPERTI ADMIN
        $pendingArticles = Article::with('user')->where('status', 'pending')->latest()->get();
        $approvedArticles = Article::with('user')->where('status', 'approved')->latest()->get();
        $rejectedArticles = Article::with('user')->where('status', 'rejected')->latest()->get(); // TAMBAH INI

        return view('superadmin', compact('products', 'carousels', 'users', 'pendingArticles', 'approvedArticles', 'rejectedArticles'));
    }

    public function approveArticle($id)
    {
        $article = Article::findOrFail($id);
        
        $article->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'rejection_reason' => null // Clear rejection reason jika ada
        ]);

        return redirect()->back()
            ->with('article_success', 'Artikel berhasil disetujui!')
            ->with('active_article_tab', 'approved');
    }

    public function rejectArticle(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $article = Article::findOrFail($id);
        
        $article->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'approved_by' => null, // Clear approved data
            'approved_at' => null
        ]);

        return redirect()->back()
            ->with('article_success', 'Artikel berhasil ditolak!')
            ->with('active_article_tab', 'rejected');
    }

    // Method lainnya tetap sama...
    public function promoteToAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->role === 'admin') {
            return back()->with('error', 'User ini sudah menjadi admin.');
        }

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak bisa mengubah role superadmin.');
        }

        $user->update(['role' => 'admin']);

        return back()->with('admin_success', 'User berhasil dijadikan admin.');
    }

    public function demoteAdmin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak bisa mengubah role superadmin.');
        }

        $user->update(['role' => 'user']);

        return back()->with('admin_success', 'Admin berhasil diturunkan menjadi user.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak bisa menghapus superadmin.');
        }

        $user->delete();

        return back()->with('admin_success', 'User berhasil dihapus.');
    }
}
