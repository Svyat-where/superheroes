<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Hero extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nick_name',
        'real_name',
        'description',
        'powers',
        'phrase',
        'images'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    

}
