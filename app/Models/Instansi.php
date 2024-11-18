<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Instansi extends Model
{
    use HasFactory;
    protected $table = "instansis";
    protected $fillable = ['name', 'address', 'negara_id', 'coordinates', 'ptqs', 'status', 'badan_kemitraan'];
    public $timestamps = false;

    public function negara()
    {
        return $this->belongsTo(Negara::class, "negara_id");
    }

    public function getInstansis($instansiName)
    {
        return self::where('name', 'like', '%' . $instansiName . '%')->get();
    }
}
