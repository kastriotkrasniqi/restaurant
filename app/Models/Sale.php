<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;


    public function table()
    {
        return $this->belongsTo(Table::class);
    }


    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}