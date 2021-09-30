<?php

namespace App\Services;

use App\Models\Hero;
use App\Models\Image;
Use File;

Class HeroService {
    protected  $hero;

    public function __construct(Hero $hero)
    {
        $this->hero = $hero;
    }

    public function findAllHeroes() {

        return $this->hero->all();
    }
    

    public function createHero(string $nick_name, string $real_name, $description, string $powers, string $phrase){
        
        if ($this->hero->findByNick($nick_name)) {
            return response($nick_name.' already exists!', 404);
        }
        Hero::create([
            'nick_name' => $nick_name,
            'real_name' => $real_name,
            'description' => $description,
            'powers' => $powers,
            'phrase' => $phrase,
        ]);

        return $this->hero->findByNick($nick_name)->nick_name;
    }

    public function editHero(string $odd_nick_name, string $nick_name, string $real_name, $description, string $powers, string $phrase)
    {
        $nick = $odd_nick_name;
        $hero = Hero::findByNick($nick);
        
        $hero->nick_name = $nick_name;
        $hero->real_name = $real_name;
        $hero->description = $description;
        $hero->powers = $powers;
        $hero->phrase = $phrase;
        $hero->save();
    }

    public function deleteHero(string $nick_name)
    {
        $heroNick = $nick_name;
        $hero = Hero::findByNick($heroNick);
        $heroId = $hero->id;
        $images = Image::getImageByHeroId($heroId);

        foreach($images as $image) {
            File::delete(public_path('images/'.$image->name));
            $image->delete();
        }

        $hero->delete();

    }


    public function heroList() 
    {
        
        $heroNames = $this->hero->all()->pluck('nick_name');
        $heroIds = Hero::all()->pluck('id');
        $images = [];



        foreach($heroIds as $heroId) {
            array_push($images, asset('images/'.Image::where('hero_id', $heroId)->pluck('name')->first()));
        }

        for ($i = 0; $i < count($images); $i++) {
            if ($images[$i] == 'http://127.0.0.1:8000/images') {
                $images[$i] = 'http://127.0.0.1:8000/images/no-hero.png';
            }
        }

        $list = array();
        foreach($heroNames as $index => $heroName) {
            
            $list[] = ['nick_name' => $heroName, 'image' => $images[$index]];
        }
        return $list;
    }

}