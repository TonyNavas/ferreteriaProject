<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\{Category, Image, Inventory, PurchaseOrder, Quote};

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'category_id',
    ];

    // Accesores

    protected function imageProduct(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url('public/'.$this->image->path)
        );
    }

    // Relacion uno a muchos inversa

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relacion uno a muchos

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    // Relacion muchos a muchos polimorfica

    public function purchaseOrders()
    {
        return $this->morphedByMany(PurchaseOrder::class, 'productable');
    }

    public function quotes()
    {
        return $this->morphedByMany(Quote::class, 'productable');
    }

    // Relacion polimorfica

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
