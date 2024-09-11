<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggiatKerjasama extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the fakultas that owns the PenggiatKerjasama
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_pihak', 'id');
    }
}
