<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline_at',
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
    ];

    protected $table = 'job_vacancies';

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
