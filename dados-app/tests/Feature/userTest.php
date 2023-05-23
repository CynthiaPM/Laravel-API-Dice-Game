<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Laravel\Passport\Passport;

class userTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    // user registration

    public function test_can_register(){
        
        $successfullRegister = $this->postJson(route('user.register'),[
            'email' => fake()->unique()->email(),
            'password' => bcrypt('Password')
        ]);

        $successfullRegister->assertJsonStructure([
            'token',
        ])->assertStatus(201);
    }

    public function test_cant_register(){

        //the form is working

        // $load = $this->get(route('user.register'));
        // $load->assertStatus(200);

        //wrong register test

        $badRegister = $this->postJson(route('user.register'),[
            "email" => "aaaa",
            "password" => "a"
        ]);

        $badRegister->assertStatus(422);

    }

    //user login

    public function test_can_login(){
        

        $user = User::factory()->create();

        //successfull user login

        $successfullLogin = $this->postJson(route('user.login'),[
            'email' => $user->email,
            'password' => 'password'
        ]);

        $successfullLogin->assertJsonStructure([
            'token',
        ])->assertStatus(200);
        // $successfullLogin ->assertJsonStructure(['token']);                
    }

    public function test_cant_login(){
        
        $wrongLogin= $this->postJson(route('user.login'),[
            'email' => 'aaaaa@lala.com',
            'password' => 'password'
        ]);

        $wrongLogin->assertJsonStructure([
            'error',
        ])->assertStatus(401);
    }

    //test changin name of user

    public function test_player_can_update_their_name(){

        $user = User::factory()->create()->assignRole('player');

        Passport::actingAs($user);

        //changing name

        $newName= 'nameChangeVictory';

        $this->patchJson(route('user.update',$user->id),[
            'name' => $newName
        ])->assertStatus(200)->assertJsonStructure(['message']);
    }

    public function test_another_player_cant_update_other_player_name(){

        $user = User::factory()->create()->assignRole('player');

        Passport::actingAs($user);

        //changing name

        $newName= 'nameChangeVictory';

        $this->patchJson(route('user.update',$user->id-1),[
            'name' => $newName
        ])->assertStatus(401)->assertJsonStructure([
            'error',
        ]);
    }


    


    
}
