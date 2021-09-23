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

        return $this->hero->createHero($request);
        //return response(200);
    }

    public function editHero(Request $request) 
    {

        $this->hero->editHero($request);
    }

    public function deleteHero(Request $request)
    {
        $this->hero->deleteHero($request);
    }

    public function heroList(Request $request)
    {
        // $list = new HeroService();
        return response($this->hero->heroList(), 200);
    }
    public function show(Request $request)
    {
        return $this->hero->findAllHeroes();
    }
}
