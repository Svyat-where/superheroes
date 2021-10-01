<?php

namespace App\Services;

use App\Models\Hero;


Class HeroService {
    protected  $hero;

    public function __construct(Hero $hero, FileInterface $file)
    {
        $this->hero = $hero;
        $this->file = $file;
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

        $images = $this->file->getFiles($heroNick);
        
        foreach($images as &$image)
        {
            $image = explode('/',$image);
            $image = end ($image);
            $this->file->deleteFile($image);
        }
        $this->file->deleteFolder($heroId);

        $hero->delete();

    }


    public function heroList() 
    {
        
        $heroNames = $this->hero->all()->pluck('nick_name');
        $heroIds = Hero::all()->pluck('id');

        $images = $this->file->show(json_decode($heroIds));
        
        $list = array();
        foreach($heroNames as $index => $heroName) {
            
            $list[] = ['nick_name' => $heroName, 'image' => $images[$index]];
        }

        return $list;
    }

}