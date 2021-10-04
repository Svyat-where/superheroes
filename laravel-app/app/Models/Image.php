<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hero;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'hero_id'
    ];

    public function hero()
    {
        return $this->belongsTo(Hero::class);
    }

    
}
