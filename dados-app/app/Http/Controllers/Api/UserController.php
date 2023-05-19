<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        

        
        return response(['message'=>'no']);
    }

    /**
     * User register
     */

    public function register(Request $request){
        $this->validate($request,[
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ])->assignRole('player');

        $token = $user->createToken('Personal Acces Token')-> accessToken;

        return response()->json(['token'=>$token],200);

    }

    //average fo the success rate of all users

        public function averageSuccessRate()
    {
        $average = User::avg('success_rate');

        return $average;
    }

    //found the player with worse sucess ranking

    public function worseSuccessRate(){

        $worsePlayer = User::orderBy('success_rate','asc')
        ->select('name','success_rate')
        ->first();

        return $worsePlayer;

    }

    //found the player with best success ranking

    public function bestSuccessRate(){

        $bestPlayer = User::select('name','success_rate')
        ->orderByDesc('success_rate')
        ->take(1)
        ->get();

        return $bestPlayer;

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

    // public function findId($id){

    //     return User::findOrFail($id);

    // }
   

    /**
     * Update the name of the player
     */
    public function update(Request $request, $id)
    {
        $user= User::find($id);

        $user-> name = $request->input('name');

        $user-> save();

        return response()->json([
            'message'=> 'Successfully edited'], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
