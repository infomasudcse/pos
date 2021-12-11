<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->hasMany(User::class);
    }
     public function inventory(){
        return $this->hasMany(Inventory::class);
    }
    
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }


}
