<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'cetap',
        'semester',
        'subject',
        'teacher_id',
        'date',
        'mode',
        'working_day'
    ];

    // Definir la relación con Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
