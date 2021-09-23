<?php

namespace App\Services;

interface FileInterface 
{
    public function getFiles(object $data);

    public function setFiles(object $data);

    public function deleteFile(object $data);
}