<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // Eager load relationships untuk menghindari N+1 query
        $query = Article::with(['user', 'headerImages'])
            ->approved()
            ->latest();
        
        // Filter berdasarkan genre jika ada
        if ($request->has('genre') && $request->genre !== 'all') {
            $query->where('genre', $request->genre);
        }
        
        // Pencarian jika ada parameter search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%'.$searchTerm.'%')
                  ->orWhere('content', 'like', '%'.$searchTerm.'%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%'.$searchTerm.'%');
                  });
            });
        }
        
        $articles = $query->paginate(12);
        
        return view('artikel', compact('articles'));
    }


    public function create()
    {
        return view('artikel.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'genre' => 'required|in:Budaya & Tradisi,Kearifan Lokal,Mitos & Kepercayaan,Lokasi',
            'content' => 'required',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:25600',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:25600'
        ]);

        // Buat artikel
        $article = Article::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'genre' => $validatedData['genre'],
            'content' => $validatedData['content'],
            'status' => 'pending'
        ]);

        try {
            // Upload header image ke BLOB jika ada
            if ($request->hasFile('header_image')) {
                ImageHelper::uploadImage($request->file('header_image'), $article, 'header');
            }

            // Upload gallery images ke BLOB jika ada
            if ($request->hasFile('gallery_images')) {
                ImageHelper::uploadMultipleImages($request->file('gallery_images'), $article, 'gallery');
            }
        } catch (\Exception $e) {
            // Jika error upload gambar, tetap simpan artikel tapi tanpa gambar
        }

        return redirect()->route('artikel')->with('success', 'Artikel berhasil diajukan untuk review!');
    }

    /**
     * SHOW METHOD SEDERHANA - TANPA MODE ADMIN PREVIEW
     */
    public function show($id)
    {
        // Eager load semua relationships yang diperlukan
        $article = Article::with(['user', 'images', 'headerImages', 'galleryImages'])->findOrFail($id);
        
        // Cek permission untuk melihat artikel
        $canView = false;
        
        if ($article->status === 'approved') {
            // Artikel approved bisa dilihat semua orang
            $canView = true;
        } elseif (Auth::check()) {
            $user = Auth::user();
            
            // Pemilik artikel bisa lihat artikelnya sendiri (pending/rejected)
            if ($user->id === $article->user_id) {
                $canView = true;
            }
            
            // Admin dan superadmin bisa lihat semua artikel untuk keperluan review
            if (in_array($user->role, ['admin', 'superadmin'])) {
                $canView = true;
            }
        }
        
        // Jika tidak boleh lihat, 404
        if (!$canView) {
            abort(404);
        }

        return view('artikel.show', compact('article'));
    }
}