<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
     	'total_item',
     	'subtotal',
        'total_sale',
        'totalWTax',
        'changeamount',
        'total_payment',
        'total_tax',
        'total_discount',
        'user_id',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function saleitems()
    {
        return $this->hasMany(Saleitems::class);
    }

     public function salepayments()
    {
        return $this->hasMany(Salepayments::class);
    }

     public function saletax()
    {
        return $this->hasMany(Saletax::class);
    }
}