<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';
    protected $primaryKey = 'id';
    protected $fillable = [
      'branch_id',
       'item_id',
       'sku' ,
       'variation',
       'qty' ,
       'cost_price',
       'unit_price',
    ];


    public function item()
	{
    	return $this->belongsTo(Item::class);
	}
	public function branch()
	{
    	return $this->belongsTo(Branch::class);
	}
}