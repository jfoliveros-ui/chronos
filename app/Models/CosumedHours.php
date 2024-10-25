<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CosumedHours extends Model
{
    protected $table = 'consumed_hours';

    protected $fillable = [
        'schedules_id',
        'consumed_hours',
        'cut',
        'year',
        'categorie',
        'value_hour',
        'resolution',
        'value_pensioner',
        'value_total'
    ];
    // Relación con Schedule
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedules_id');
    }
}
