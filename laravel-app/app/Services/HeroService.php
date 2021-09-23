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
    

    public function createHero(object $data){
        
        if ($this->hero->findByNick($data->nick_name)) {
            return response($data->nick_name.' already exists!', 404);
        }
        Hero::create([
            'nick_name' => $data->nick_name,
            'real_name' => $data->real_name,
            'description' => $data->description,
            'powers' => $data->powers,
            'phrase' => $data->phrase,
        ]);

        return $this->hero->findByNick($data->nick_name)->nick_name;
    }

    public function editHero(object $data)
    {
        $nick = $data->odd_nick_name;
        $hero = Hero::findByNick($nick);
        
        $hero->nick_name = $data->nick_name;
        $hero->real_name = $data->real_name;
        $hero->description = $data->description;
        $hero->powers = $data->powers;
        $hero->phrase = $data->phrase;
        $hero->save();
    }

    public function deleteHero(object $data)
    {
        $heroNick = $data->nick_name;
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