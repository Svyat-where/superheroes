<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
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

    public function setImages(FileRequest $request) 
    {
        $files = $request->file('files');
        $id = $request->id;

        if($request->hasfile('files')) {
            $this->image->setFiles($id, $files);

            return response('Files are setup', 200);
        } else {
            return response('No files were sent', 404);
        }
    

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
