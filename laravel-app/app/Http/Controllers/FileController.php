<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileInterface;
use App\Models\Image;
use App\Models\Hero;

class FileController extends Controller
{

    protected $image;

    public function __construct(FileInterface $file)
    {
        $this->image = $file;
    }

    public function setImages(Request $request) 
    {
        $id = $request->id;
   
        return $this->image->setFiles($id, $request);

    }

    public function getImages(Request $request)
    {
        $id = $request->id;

        return $this->image->getFiles($id);
    }

    public function deleteImage(Request $request) 
    {
        $imageName = $request->image;
        $this->image->deleteFile($imageName);
    }
}
