<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Instansi extends Model
{
    use HasFactory;
    protected $table = "instansis";

    public function getNegara(){
        return $this->belongsTo(Negara::class, "negara_id");
    }
}
