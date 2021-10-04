<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Hero;
use File;

class ServerFileService implements FileInterface {

    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }
    public function setFiles(int $id, array $files) 
    {

        // if ($files->hasfile('files')) {
            foreach ($files as $file) {
                $imageName = $file->getClientOriginalName();
                $file->move(public_path('images/'.$id), $imageName);
                Image::create([
                    'hero_id' => $id,
                    'name' => $imageName
                ]);
            }
        //} 
    }

    public function getFiles(int $id) 
    {
        $images = $this->image->where('hero_id', $id)->get();
        $result = [];

        foreach($images as $image)
        {
            array_push($result, asset('images/'.$id.'/'.$image->name));
        }

        return $result;
    }

    public function deleteFile(string $imageName) 
    {

        $image = $this->image->where('name', $imageName);
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

        foreach($ids as $id) 
        {
            for ($i = 0; $i < count($images); $i++) {
                if ($images[$i] == 'http://127.0.0.1:8000/images/'.$id) {
                    $images[$i] = 'http://127.0.0.1:8000/images/no-hero.png';
                }
            }
        }

        return $images;
    }
    
}