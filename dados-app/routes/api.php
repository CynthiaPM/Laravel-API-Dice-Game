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

Route::post('players',[UserController::class,'register'])->name('user.register');
Route::post('login',[UserController::class,'login'])->name('user.login');


Route::middleware('auth:api')->group(function(){

//logout
Route::post('logout',[UserController::class,'logout'])->name('user.logout')->middleware('role:admin,player');

//update player name
Route::patch('players/{id}',[UserController::class,'update'])->name('user.update')->middleware('role:player');

//throw the dices
Route::post('players/{id}/games',[GameController::class, 'throwDice'])->name('game.throwDice')->middleware('role:player');

//delete all the games of the player
Route::delete('players/{id}/games',[GameController::class,'destroy'])->name('game.destroy')->middleware('role:player');

//show all the games of the player to the player and the ranking
Route::get('players/{id}/games',[GameController::class,'index'])->name('game.index')->middleware('role:player');

//show all the players and the success rating of every one.
Route::get('players',[UserController::class,'index'])->name('ranking.index')->middleware('role:admin');

//show the average success ranking of all users
Route::get('players/ranking',[UserController::class,'averageSuccessRate'])->name('ranking.averageSuccessRate')->middleware('role:admin');

//Show the worse player

Route::get('/players/ranking/loser',[UserController::class,'worseSuccessRate'])->name('ranking.worseSuccessRate')->middleware('role:admin');

//Show the best player 

Route::get('/players/ranking/winner',[UserController::class,'bestSuccessRate'])->name('ranking.bestSuccessRate')->middleware('role:admin');



});