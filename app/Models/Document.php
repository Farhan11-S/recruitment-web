<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'application_id',
        'document_name',
        'file_path',
    ];

    /**
     * Sebuah dokumen dimiliki oleh satu aplikasi.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
