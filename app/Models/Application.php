<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'job_vacancy_id',
    ];

    /**
     * Sebuah aplikasi dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Sebuah aplikasi terkait dengan satu lowongan pekerjaan.
     */
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }
}
