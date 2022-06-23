<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded=[];
    public $timestamps =false;
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}
