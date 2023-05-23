<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foun,dation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Game;
use Laravel\Passport\Passport;

class GameTest extends TestCase
{
    // /**
    //  * A basic feature test example.
    //  */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    //player make the game

    public function test_player_can_throw_the_dices(){
        
        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $this->postJson(route('game.throwDice',$user->id))->assertStatus(200)->assertJsonStructure([
            'dice1',
            'dice2',
            'status'
           ]);
    }

    public function test_player_cant_throw_the_dices_of_another_player(){
        
        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $this->postJson(route('game.throwDice',$user->id-1))->assertStatus(401)->assertJsonStructure([
            'error'
           ]);
    }

    //test user can see their games and ranking

    public function test_player_see_page_game_and_ranking(){

        $user = User::factory()->create()->assignRole('player');

        Passport::actingAs($user);

        $ranking = $this->getJson(route('game.index',$user->id));

       $ranking->assertStatus(200)->assertJsonStructure([
        'games',
        'success_rate'
       ]);

    }

    public function test_admin_cant_see_the_player_page_game_and_ranking(){

        $user = User::factory()->create()->assignRole('admin');

        Passport::actingAs($user);

        $ranking = $this->getJson(route('game.index',$user->id));

       $ranking->assertStatus(403);

    }

    public function test_other_player_cant_see_the_player_page_game_and_ranking(){

        $user = User::factory()->create()->assignRole('player');

        Passport::actingAs($user);

        $ranking = $this->getJson(route('game.index',$user->id-1));

       $ranking->assertStatus(401)->assertJsonStructure([
        'error'
       ]);

    }

    //delete games

    public function test_player_can_delete_their_games(){
        
        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);
        Game::factory(5)->create(['user_id' => $user->id]);

        $this->deleteJson(route('game.destroy',$user->id))->assertStatus(200)->assertJsonStructure([
            'message'
           ]);
        
        $this->assertEquals(0, $user->games()->count());
    }

    public function test_player_cant_delete_another_players_games(){
        
        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);
        Game::factory(5)->create(['user_id' => $user->id]);

        $this->deleteJson(route('game.destroy',$user->id-1))->assertStatus(401)->assertJsonStructure([
            'error'
           ]);

           $this->assertEquals(5, $user->games()->count());
    }
}
