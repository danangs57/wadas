<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function transactions()
    {
        return $this->belongsToMany(Transaction::class,'product_transaction');
    }
}
