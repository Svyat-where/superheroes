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
    /**
     * Return the specified hero.
     *
     * @param string $nick_name
     * 
     * @return Hero
     */
    
    public function show(string $nick_name) : Hero
    {
        $hero = $this->hero->where('nick_name', $nick_name)->firstOrFail();

        return $hero;
    }

     /**
     * Create hero.
     *
     * @param  Request  $request
     * @param int $id
     * @param  string $nick_name
     * @param string $real_name
     * @param string $description
     * @param string $powers
     * @param string @phrase
     * @return Hero
     */

    public function create(string $nick_name, string $real_name, string $description, string $powers, string $phrase)
    {
        
        $heroes = $this->hero->all()->pluck('nick_name');

        foreach($heroes as $hero) {
            if (str_split($hero) === str_split($nick_name)) {

                return response($nick_name.' already exists!', 404);
            }
        }

        $hero = $this->hero->create([
            'nick_name' => $nick_name,
            'real_name' => $real_name,
            'description' => $description,
            'powers' => $powers,
            'phrase' => $phrase,
        ]);

        return $hero;
    }

    /**
     * Update the specified hero.
     *
     * @param  int  $id
     * @param  string $nick_name
     * @param string $real_name
     * @param string $description
     * @param string $powers
     * @param string @phrase
     * @return boll
     */

    public function update(int $id, string $nick_name, string $real_name, string $description, string $powers, string $phrase): bool
    {

        $hero = $this->hero->find($id);
        
        $hero->nick_name = $nick_name;
        $hero->real_name = $real_name;
        $hero->description = $description;
        $hero->powers = $powers;
        $hero->phrase = $phrase;

        $hero->save();
        return true;
    }

     /**
     * Delete the specified hero.
     *
     * @param  int  $id
     * @return 
     */

    public function delete(int $id)
    {
        $hero = $this->hero->find($id);

        $images = $this->file->getFiles($id);
        
        foreach($images as &$image)
        {
            $image = explode('/',$image);
            $image = end ($image);
            $this->file->deleteFile($image);
        }
        $this->file->deleteFolder($id);

        $hero->delete();

    }


    public function heroList() 
    {
        
        $heroNames = $this->hero->all()->pluck('nick_name');
        $heroIds = $this->hero->all()->pluck('id');

        $images = $this->file->show(json_decode($heroIds));
        
        $list = array();
        foreach($heroNames as $index => $heroName) {
            
            $list[] = ['nick_name' => $heroName, 'image' => $images[$index]];
        }

        return $list;
    }

}