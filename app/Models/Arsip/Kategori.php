<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Get all of the arsip for the Kategori
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsip(): HasMany
    {
        return $this->hasMany(Arsip::class, 'kategori_id');
    }
}
