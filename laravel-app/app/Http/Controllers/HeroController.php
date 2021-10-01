<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Services\HeroService;

class HeroController extends Controller
{

    public function __construct(HeroService $hero)
    {
        $this->hero = $hero;
    }

    public function getHeroByNick(Request $request) 
    {
        
        $nick = $request->nick_name;
        $hero = Hero::findByNick($nick);

        return $hero;
    }

    public function createHero(Request $request) 
    {
        $nick_name = $request->nick_name;
        $real_name = $request->real_name;
        $description = $request->description;
        $powers = $request->powers;
        $phrase = $request->phrase;

        return $this->hero->createHero($nick_name, $real_name, $description, $powers, $phrase);
    }

    public function editHero(Request $request) 
    {
        $odd_nick_name = $request->odd_nick_name;
        $nick_name = $request->nick_name;
        $real_name = $request->real_name;
        $description = $request->description;
        $powers = $request->powers;
        $phrase = $request->phrase;

        $this->hero->editHero($odd_nick_name, $nick_name, $real_name, $description, $powers, $phrase);
    }

    public function deleteHero(Request $request)
    {
        $nick_name = $request->nick_name;

       return $this->hero->deleteHero($nick_name);
    }

    public function heroList(Request $request)
    {
        return response($this->hero->heroList(), 200);
    }
    public function show(Request $request)
    {
        return $this->hero->findAllHeroes();
    }
}
