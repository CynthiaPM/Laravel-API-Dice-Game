<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users routes

Route::post('players',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);


Route::middleware('auth:api')->group(function(){

//logout
Route::post('logout',[UserController::class,'logout']);

//update player name
Route::put('players/{id}',[UserController::class,'update']);

//throw the dices
Route::post('players/{id}/games',[GameController::class, 'throwDice']);

//delete all the games of the player
Route::delete('players/{id}/games',[GameController::class,'destroy']);

//show all the games of the player
Route::get('players/{id}/games',[GameController::class,'index']);

//show all the players and the success rating of every one.
Route::get('players',[UserController::class,'index']);

//show the average success ranking of all users
Route::get('players/ranking',[UserController::class,'averageSuccessRate']);

//Show the worse player

Route::get('/players/ranking/loser',[UserController::class,'worseSuccessRate']);

//Show the best player 

Route::get('/players/ranking/winner',[UserController::class,'bestSuccessRate']);



});