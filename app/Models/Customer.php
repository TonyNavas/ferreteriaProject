<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'indentity_id',
        'document_number',
        'name',
        'address',
        'email',
        'phone',
    ];
}
