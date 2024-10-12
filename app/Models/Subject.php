<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject',
        'teacher_id',
    ];

    // Definir la relación con Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
