<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_document',
        'document_number',
        'full_name',
        'address',
        'phone',
        'origin',
        'email',
        'categorie',
        'pensioner',
        'curriculum'
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
