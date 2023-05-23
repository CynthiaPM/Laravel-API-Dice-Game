<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    
    public function index($id){

        //get the id of the authenticated user

        $authenticatedUserId = Auth::id();        

        if($authenticatedUserId == $id){

            $user = User::find($id);

            return response()->json([
                'games'=>$user->games,
                'success_rate'=>$user->success_rate],200);

        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }       

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

        $authenticatedUserId = Auth::id();        

        if($authenticatedUserId == $id){

            $game = $this->createGame($this->diceLogic(), User::find($id));

        return response()->json([
            'dice1' => $game-> dice1,
            'dice2' => $game-> dice2,
            'status' => $game-> status ? 'win' : 'lose'
        ],200);

        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        

    }

    public function destroy($id){

        $authenticatedUserId = Auth::id();        

        if($authenticatedUserId == $id){

            $user = User::find($id);

            $user->games()->delete();

            return response()->json(['message'=>'Successfully delete'], 200);

        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


}
