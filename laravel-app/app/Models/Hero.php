<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function findById($id) {
        
        return self::where('id', $id)->first();
    }


    public static function findByNick($nick) {
        

        return self::where('nick_name', $nick)->first();
    }


}
