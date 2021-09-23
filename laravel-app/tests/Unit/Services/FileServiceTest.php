<?php

namespace Tests\Unit\Services;

use Tests\TestCase; 
use App\Services\ServerFileService;

class FileServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function testGetImages()
    {
        $data = (object) [
            'nick_name' => 'svyat'
        ];

        $file = new ServerFileService();
        $result = [$file->getFiles($data)[0]];
        $expected = ["http://localhost/images/1.png"];
        
        $this->assertTrue($expected == $result);
    }
}
