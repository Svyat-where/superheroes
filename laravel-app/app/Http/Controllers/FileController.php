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
        $this->image->setFiles($request);
        if ($request->hasfile('files')) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header('Access-Control-Allow-Headers: *');
            
            //return dd($request->file('files'));
        }

        return response('bad', 404);
    }

    public function getImages(Request $request)
    {
        return $this->image->getFiles($request);
    }

    public function deleteImage(Request $request) 
    {
        $this->image->deleteFile($request);
    }
}
