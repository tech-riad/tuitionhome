<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorImport extends Model
{
    protected $fillable = [
        'storage_path',
        'original_filename',
        'status',
        'uploaded_by',
        'inserted',
        'skipped',
        'duplicate_phone',
        'duplicate_email',
        'invalid_phone',
        'row_errors',
        'error_message',
        'started_at',
        'finished_at',
    ];

    protected $dates = [
        'started_at',
        'finished_at',
    ];
}
