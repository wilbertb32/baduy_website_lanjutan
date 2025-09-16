<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id', // Tambahkan ini untuk Socialite
        'role', // JANGAN PERNAH DIHAPUS!
        'profile_photo_path' // Tambahkan ini untuk konsistensi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // =================================
    // EXISTING RELATIONSHIPS - JANGAN DIHAPUS
    // =================================
    
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    // =================================
    // ROLE METHODS - RESTORE SEMUA METHOD YANG ADA SEBELUMNYA
    // =================================
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function canAccessAdmin()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    public function getRoleAttribute($value)
    {
        return $value ?? 'user'; // Default role
    }

    // =================================
    // PROFILE IMAGE SYSTEM - PERBAIKAN
    // =================================

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function profileImages()
    {
        return $this->morphMany(Image::class, 'imageable')->where('image_type', 'profile');
    }

    public function profileImage()
    {
        return $this->profileImages()->first();
    }

    /**
     * Get the URL to the user's profile photo.
     * Method ini akan menjadi sumber tunggal untuk profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Prioritas 1: Profile image dari relationship (jika ada)
        if ($this->profileImage()) {
            return route('image.show', $this->profileImage()->id);
        }
        
        // Prioritas 2: profile_photo_path (jika ada)
        if ($this->profile_photo_path) {
            return filter_var($this->profile_photo_path, FILTER_VALIDATE_URL) 
                ? $this->profile_photo_path 
                : asset('storage/'.$this->profile_photo_path);
        }
        
        // Fallback: Default avatar
        return $this->defaultProfilePhotoUrl();
    }

    /**
     * Generate default avatar URL
     */
    public function defaultProfilePhotoUrl()
    {
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&color=7C3AED&background=EBF4FF&size=200";
    }
}