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
                $file->move(public_path('images/'.$hero->id), $imageName);
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
            array_push($images, asset('images/'.$heroId.'/'.Image::getImageByHeroId($heroId)[$i]->name));
        }

        return $images;
    }

    public function deleteFile(string $imageName) 
    {

        $image = Image::getImageByName($imageName);
        $heroId = $image->hero->id;
        $image->delete();
        File::delete(public_path('images/'.$heroId.'/'.$imageName));

        return $imageName;
    }

    public function deleteFolder(string $folderName)
    {
        File::deleteDirectory(public_path('images/'.$folderName));
    }


    public function show(array $ids)
    {
        $images = [];
        foreach($ids as $id) {
            array_push($images, asset('images/'.$id.'/'.Image::where('hero_id', $id)->pluck('name')->first()));
        }

        for ($i = 0; $i < count($images); $i++) {
            if ($images[$i] == 'http://127.0.0.1:8000/images') {
                $images[$i] = 'http://127.0.0.1:8000/images/no-hero.png';
            }
        }

        return $images;

    }
    
}