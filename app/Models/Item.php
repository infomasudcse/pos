<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $primaryKey = 'id';

    public function category()
	{
    	return $this->belongsTo(Category::class);
	}

	public function subcategory()
	{
    	return $this->belongsTo(Subcategory::class);
	}

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
