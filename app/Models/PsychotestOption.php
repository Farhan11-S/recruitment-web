<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychotestOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'psychotest_question_id',
        'option_text',
        'is_correct',
    ];

    /**
     * Sebuah pilihan jawaban dimiliki oleh satu pertanyaan.
     */
    public function question()
    {
        return $this->belongsTo(PsychotestQuestion::class, 'psychotest_question_id');
    }
}
