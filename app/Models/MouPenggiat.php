<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouPenggiat extends Model
{
    protected $table = 'mou_penggiat';
    protected $fillable = ['id', 'id_lapkerma', 'pihak', 'id_pihak', 'id_pj', 'id_pejabat', 'fakultas_pihak', 'prodi'];
    use HasFactory;
}
