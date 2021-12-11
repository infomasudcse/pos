<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variationval extends Model
{
    use HasFactory;
    protected $table = 'variationvals';
    protected $primaryKey = 'id';

    public function variation()
	{
    	return $this->belongsTo(Variation::class);
	}
}
