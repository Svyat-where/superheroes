<?php

namespace Tests\Unit\Services;

use Tests\TestCase; 
//use PHPUnit\Framework\TestCase;
use App\Services\HeroService;
use App\Models\Hero;

class HeroServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $data = (object)[
            'nick_name' => 'ssss',
            'real_name' => 'ss',
            'description' => 'ss',
            'powers' => 'ss',
            'phrase' => 'ss',
        ];
        $hero = new HeroService(new Hero());
        $result = $hero->createHero($data);
        $this->assertEquals(strlen('ssss'), strlen($result));
    }
}
