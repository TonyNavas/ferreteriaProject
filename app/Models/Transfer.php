<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'type',
        'serie',
        'correlative',
        'date',
        'total',
        'observation',
        'origin_warehouse_id',
        'destination_warehouse_id',
    ];

    // Relacion muchos a muchos polimorfica

    public function products()
    {
        return $this->morphToMany(Product::class, 'productable_id')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }

    // Relacion uno a muchos inversas

    public function originWarehouse(){
        return $this->belongsTo(Warehouse::class, 'origin_warehouse_id');
    }

        public function destinationWarehouse(){
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }
}
