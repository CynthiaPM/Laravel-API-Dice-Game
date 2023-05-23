<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class RankingTest extends TestCase
{
    // /**
    //  * A basic feature test example.
    //  */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    //all the names and ranking

    public function test_admin_can_see_all_the_names_and_ranking(){

        $user= User::factory()->create()->assignRole('admin');
        Passport::actingAs($user);

        $this->getJson(route('ranking.index'))->assertStatus(200);

    }

    public function test_player_cant_see_all_the_names_and_ranking(){

        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $this->getJson(route('ranking.index'))->assertStatus(403);

    }

    //the average success ranking of all users

    public function test_admin_can_see_the_average_success_ranking_of_all_players(){
        $user= User::factory()->create()->assignRole('admin');
        Passport::actingAs($user);

        $this->getJson(route('ranking.averageSuccessRate'))->assertStatus(200)->assertStatus(200)->assertJsonStructure([
            'success_rate'
        ]);
    }

    public function test_player_cant_see_the_average_success_ranking_of_all_players(){
        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $this->getJson(route('ranking.averageSuccessRate'))->assertStatus(403);
    }

    //the best player

    public function test_admin_can_see_the_player_with_best_ranking(){
        
        $user= User::factory()->create()->assignRole('admin');
        Passport::actingAs($user);

        $this->getJson(route('ranking.bestSuccessRate'))->assertStatus(200)->assertJsonStructure([
            'player',
            'success_rate'
        ]);

    }

    public function test_player_cant_see_the_player_with_best_ranking(){
        
        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $this->getJson(route('ranking.bestSuccessRate'))->assertStatus(403);

    }

    // show worse player

    public function test_admin_can_see_the_player_with_worse_ranking(){
        
        $user= User::factory()->create()->assignRole('admin');
        Passport::actingAs($user);

        $this->getJson(route('ranking.worseSuccessRate'))->assertStatus(200)->assertStatus(200)->assertJsonStructure([
            'player',
            'success_rate'
        ]);

    }

    public function test_player_can_see_the_player_with_worse_ranking(){
        
        $user= User::factory()->create()->assignRole('player');
        Passport::actingAs($user);

        $this->getJson(route('ranking.worseSuccessRate'))->assertStatus(403);

    }


}
