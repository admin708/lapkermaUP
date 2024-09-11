<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_fakultas'
    ];


    /**
     * Get all of the prodi for the Fakultas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'id_fakultas', 'id');
    }
}
