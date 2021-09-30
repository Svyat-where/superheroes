<?php

namespace App\Services;

interface FileInterface 
{
    public function getFiles(string $nick_name);

    public function setFiles(object $data);

    public function deleteFile(string $imageName);
}