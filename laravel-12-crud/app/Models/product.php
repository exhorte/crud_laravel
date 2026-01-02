<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;
    

    protected $fillable = [
        "name",
        "description",
        "quantite",
        "category_id",
        "price",
        "status",
        "image"
    ];

    public function category(){
        return $this->belongsTo(category::class);
    }
}
