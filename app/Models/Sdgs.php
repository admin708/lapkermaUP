<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Sdgs extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama','uuid'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString(); // Mengisi kolom 'uuid' dengan UUID baru
        });
    }
}