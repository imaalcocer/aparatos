<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = ['codigo_producto', 'title', 'description', 'release_date', 'image'];

    /**
     * Relación de muchos a muchos con marcas.
     */
    public function marcas(): BelongsToMany
    {
        return $this->belongsToMany(Marcas::class, 'marcas_productos', 'producto_id', 'marca_id');
    }
}
