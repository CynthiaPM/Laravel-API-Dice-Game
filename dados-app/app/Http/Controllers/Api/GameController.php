<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;

class GameController extends Controller
{
    
    public function index($id){

        return response()->json(User::find($id)->games,200);

    }

    public function diceLogic(){

        $dice1 = rand(1,6);
        $dice2 = rand(1,6);

        return ([
            'dice1' => $dice1,
            'dice2' => $dice2,
            'status' => $dice1 + $dice2 === 7
        ]);
    }

    public function createGame($dice, $user){

        $game = $user->games()->create($dice);

        $user->success_rate= $user->calculateSuccessRate();

        $user->save();

        return $game;     
    }

    public function throwDice($id){

        $game = $this->createGame($this->diceLogic(), User::find($id));

        return response()->json([
            'dice1' => $game-> dice1,
            'dice2' => $game-> dice2,
            'status' => $game-> status ? 'win' : 'lose'
        ],200);

    }

    public function destroy($id){

        $user = User::find($id);

        $user->games()->delete();

        return response()->json(['message'=>'Successfully delete'], 200);


    }


}
