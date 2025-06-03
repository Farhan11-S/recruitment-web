<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'application_id',
        'token',
        'score',
        'completed_at',
    ];

    /**
     * Relasi ke model Application.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    /**
     * Relasi ke model User melalui Application.
     */
    public function user()
    {
        return $this->belongsToThrough(User::class, Application::class);
    }
}
