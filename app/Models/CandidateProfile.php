<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // user_id akan diisi otomatis jika menggunakan relasi
        'place_of_birth',
        'date_of_birth',
        'gender',
        'phone_number',
        'address',
        'resume_path',
        'is_complete', // Penting untuk diisi saat registrasi
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}