<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
     protected $table = 'categories';
    protected $primaryKey = 'id';

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
