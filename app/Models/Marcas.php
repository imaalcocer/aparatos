<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Marcas extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country', 'logo'];

    /**
     * Relación de muchos a muchos con productos.
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Productos::class, 'marcas_productos', 'marca_id', 'producto_id'); // Especificar la tabla y las columnas de claves foráneas
    }
}
