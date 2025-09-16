<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get();
        $carousels = Carousel::with('images')->orderBy('order')->get();
        
        // Ambil artikel berdasarkan status
        $pendingArticles = Article::with('user')->where('status', 'pending')->latest()->get();
        $approvedArticles = Article::with('user')->where('status', 'approved')->latest()->get();
        $rejectedArticles = Article::with('user')->where('status', 'rejected')->latest()->get(); // TAMBAH INI

        return view('admin', compact('products', 'carousels', 'pendingArticles', 'approvedArticles', 'rejectedArticles'));
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
}