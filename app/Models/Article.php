<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre', 
        'content',
        'status',
        'user_id',
        'rejection_reason',
        'approved_by',
        'reviewed_by',
        'approved_at',
        'reviewed_at'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'approved_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // =================================
    // SISTEM IMAGES - POLYMORPHIC RELATIONSHIP
    // =================================

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // PERBAIKI: Return relationship instance, bukan collection
    public function headerImages()
    {
        return $this->morphMany(Image::class, 'imageable')->where('image_type', 'header');
    }

    public function galleryImages()
    {
        return $this->morphMany(Image::class, 'imageable')
                    ->where('image_type', 'gallery')
                    ->orderBy('order');
    }

    // Helper methods untuk mendapatkan single header image
    public function getHeaderImageAttribute()
    {
        return $this->headerImages()->first();
    }

    // Helper method untuk cek apakah ada header image
    public function headerImage()
    {
        return $this->headerImages()->first();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByGenre($query, $genre)
    {
        return $query->where('genre', $genre);
    }
}
