<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouPenggiat extends Model
{
    protected $table = 'mou_penggiat';
    use HasFactory;

    public function getMou(){
        return $this->belongsTo(instansi::class, "id_pihak");
    }

    public function getPejabat(){
        return $this->belongsTo(Pejabat::class, "id_pejabat");
    }

    public function getPenanggungjawab(){
        return $this->belongsTo(PenanggungJawab::class, "id_pj");
    }
}
