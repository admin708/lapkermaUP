<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenanggungJawab extends Model
{
    use HasFactory;
    protected $table = 'penanggungjawab';
    protected $fillable = ['name', 'designation', 'email', 'phone_number'];
    public $timestamps = false;


    public function getPJ($pjName)
    {
        return self::where('name', 'like', '%' . $pjName . '%')->get();
    }
}
