<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'hero_id'
    ];

    public static function getQuantityByHeroId($id) 
    {

        return self::where('hero_id', $id)->count();
    }

    public static function getImageByHeroId($id)
    {
        
        return self::where('hero_id', $id)->get();
    }

    public static function getImageByName($name)
    {
        return self::where('name', $name)->first();
    }

    public  function hero()
    {
        return $this->belongsTo('App\Models\Hero');
    }
    
}
