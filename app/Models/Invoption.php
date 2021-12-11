<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoption extends Model
{
    use HasFactory;
    protected $table = 'invoptions';
    protected $primaryKey = 'id';
    protected $fillable = [      
       'branch_id',
       'item_id',
       'inventory_id',
       'variation' ,     
       'qty',
       'size_id',
    ];

    public function branch()
	{
    	return $this->belongsTo(Branch::class);
	}
	public function inventory()
	{
    	return $this->belongsTo(Inventory::class);
	}
	 public function item(){
    	return $this->belongsTo(Item::class);
	}

  public function size(){
    return $this->belongsTo(Size::class);
  }
}
