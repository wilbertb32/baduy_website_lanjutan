<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'created_by',
        'updated_by'
    ];

    // Images relationship
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function mainImage()
    {
        return $this->images()->where('image_type', 'main')->first();
    }

    public function galleryImages()
    {
        return $this->images()->where('image_type', 'gallery')->ordered();
    }

    // Audit trail
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}