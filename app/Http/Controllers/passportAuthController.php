<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\Models\User;
use Validator;
class passportAuthController extends Controller
{
    

    public function registerUserExample(Request $request){
          $data = $request->all();
        $validator = Validator::make($data, [
            'first_name' =>'required',
            'last_name' =>'required',
            'phone_number' =>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $user= User::create([
            'first_name' =>$request->first_name,
            'last_name' =>$request->last_name,
            'phone_number' =>$request->phone_number,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $access_token_example = 
       
        $user->createToken('APPLICATION')->accessToken;
        
        return response()->json(['token'=>$access_token_example,'user',$user],200);


        // return response()->json(200);
    }

    /**
     * login user to our application
     */
    public function login(Request $request)
    {
        $input = $request->only(['email', 'password']);

        $validate_data = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($input, $validate_data);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }

        // authentication attempt
        if (auth()->attempt($input)) {
            $token = auth()->user()->createToken('passport_token')->accessToken;
            $user= auth()->user();
            return response()->json([
                'success' => true,
                'message' => 'User login succesfully, Use token to authenticate.',
                'token' => $token,
                'user',$user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User authentication failed.'
            ], 401);
        }
    }

    /**
     * Access method to authenticate.
     *
     * @return json
     */
    public function userDetail()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data fetched successfully.',
            'data' => auth()->user()
        ], 200);
    }

    public function Logout() {
    
        auth()->logout();
        
        return response()->json(['message' => 'user successfully sigend out']);
    }

   


}

   
