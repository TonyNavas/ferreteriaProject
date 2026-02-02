<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'indentity_id',
        'document_number',
        'name',
        'address',
        'email',
        'phone',
    ];

    // Relacion uno a muchos inversa
    public function indentity()
    {
        return $this->belongsTo(Identity::class);
    }

    // Relacion uno a muchos

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
