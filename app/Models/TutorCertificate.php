<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['tutor_id', 'ssc_c', 'ssc_m', 'hsc_c', 'hsc_m', 'nid', 'university_c', 'diploma_c', 'post_graduation_c', 'cv', 'others'];

    public function updateFile($file, $column)
    {
        $this->update([
            $column => $file->storeAs('public/tutor-certificate'),
        ]);
    }
}
