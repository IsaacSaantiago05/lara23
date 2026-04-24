<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'descriptionLong',
        'price',
        'id_category',
    ];

    //Crud basico
    public function category(){
        return $this->belongsTo(Category::class, 'id_category');

    }
}
