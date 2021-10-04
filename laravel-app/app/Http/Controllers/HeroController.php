<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HeroRequest;
use App\Models\Hero;
use App\Services\HeroService;

class HeroController extends Controller
{

    public function __construct(HeroService $hero)
    {
        $this->hero = $hero;
    }

    public function show(string $nick_name) 
    {
        
        $nick = $nick_name;
        $hero = $this->hero->show($nick);

        if ($hero) {
            return response($hero, 200);
        } else {
            return error('No such hero', 404);
        }
    }

    public function create(HeroRequest $request) 
    {
        $nick_name = $request->nick_name;
        $real_name = $request->real_name;
        $description = $request->description;
        $powers = $request->powers;
        $phrase = $request->phrase;

        $hero = $this->hero->create($nick_name, $real_name, $description, $powers, $phrase);
         
        if ($hero) {
            return response($hero, 200);
        } else {
            return error('Some rules are incorrect');
        }
        
    }

    public function update(HeroRequest $request) 
    {
        $id = $request->id;
        $nick_name = $request->nick_name;
        $real_name = $request->real_name;
        $description = $request->description;
        $powers = $request->powers;
        $phrase = $request->phrase;

        $this->hero->update($id, $nick_name, $real_name, $description, $powers, $phrase);

        return response('Hero has been updated', 200);

    }

    public function delete(int $id)
    {

       return $this->hero->delete($id);
    }

    public function heroList(Request $request)
    {
        return response($this->hero->heroList(), 200);
    }

}
