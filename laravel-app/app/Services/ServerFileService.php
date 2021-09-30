<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Hero;
use File;

class ServerFileService implements FileInterface {



    public function setFiles(object $data) 
    {
        $hero = Hero::findByNick($data->nick_name);
        $heroId = $hero->id;

        if ($data->hasfile('files')) {
            foreach ($data->file('files') as $file) {
                $imageName = $file->getClientOriginalName();
                $file->move(public_path('images'), $imageName);
                Image::create([
                    'hero_id' => $heroId,
                    'name' => $imageName
                ]);
            }
        } 
    }

    public function getFiles($nick_name) 
    {
        $hero = Hero::findByNick($nick_name);
        $heroId = $hero->id;
        $imagesLength = Image::getQuantityByHeroId($heroId);
        $images = [];

        for($i = 0; $i < $imagesLength; $i++) {
            array_push($images, asset('images/'.Image::getImageByHeroId($heroId)[$i]->name));
        }

        return $images;
    }

    public function deleteFile(string $imageName) 
    {

        $image = Image::getImageByName($imageName);
        $image->delete();
        File::delete(public_path('images/'.$imageName));

        return $imageName;
    }
    
}