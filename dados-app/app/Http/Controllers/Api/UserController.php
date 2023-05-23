<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display all the players and succeess rating
     */
    public function index()
    {
                
        return response()->json([User::select('name','success_rate')->get()], 200);
    }

    /**
     * User login
     */
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $data =[ 
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($data)){
            
            $Token = Auth::user()->createToken('Personal Access Token')->accessToken;
            return response()->json(['token' => $Token],200);
            //  (['user' => Auth::user(),'access_Token' =>$accesToken]);
        }else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }      

        
    }

    /**
     * User register
     */

    public function register(Request $request){
        
        $this->validate($request,[            
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
            $user = User::create([
            'name' => $request->filled('name') ? $request->name : 'anónimo',
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ])->assignRole('player');

        $token = $user->createToken('Personal Access Token')-> accessToken;  
           
        return response()->json(['token'=>$token],201);
        
    }    
    
    /**
     * user logout
     */

    public function logout(Request $request){

        $token = Auth::user()->token();
        $token->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);

    }

    /**
     * Update the name of the player
     */
    public function update(Request $request, $id)
    {
        $authenticatedUserId = Auth::id();        

        if($authenticatedUserId == $id){

            $user = User::find($id);

            $user-> name = $request->input('name');

            $user-> save();

            return response()->json(['message'=> 'Successfully edited'], 200);

        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    //MAKING THE RANKING OF THE PLAYERS

    //average fo the success rate of all users

    public function averageSuccessRate()
    {
        $average = User::avg('success_rate');

        return response()->json([
            'success_rate'=> $average
        ]);
    }

    //found the player with worse sucess ranking

    public function worseSuccessRate(){

        $worsePlayer = User::orderBy('success_rate','asc')->first();

        return response()->json([
            'player'=>$worsePlayer->name,
            'success_rate'=>$worsePlayer->success_rate],200);

    }

    //found the player with best success ranking

    public function bestSuccessRate(){

        $bestPlayer = User::orderByDesc('success_rate')->first();

        return response()->json([
            'player' => $bestPlayer->name,
            'success_rate' => $bestPlayer->success_rate
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
