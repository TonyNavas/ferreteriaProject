<?php

namespace App\Models;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'type',
        'serie',
        'correlative',
        'date',
        'warehouse_id',
        'total',
        'observation',
        'reason_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Relacion uno a muchos inversa

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    // Relacion muchos a muchos polimorfica

    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }

    // Relacion uno a muchos polimorfica
    
    public function inventories(){
        return $this->morphMany(Inventory::class, 'inventoryable');
    }

    public function getTypeLabelAttribute()
{
    return match ($this->type) {
        1 => 'Ingreso',
        2 => 'Salida',
        default => 'Desconocido',
    };
}
}
