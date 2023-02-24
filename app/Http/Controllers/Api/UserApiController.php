<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class UserApiController extends Controller
{

    public function list()
    {
        $res = User::all();
        return $this->success(data: $res, message: 'Your email verified.', code: 201);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error(data: ['error' => $validator->errors()]);
        }

        $user = User::where('email', '=', $request->email)->first();
        if ($user != null) {
            return $this->error(message: 'email already in use.');
        }

        $otp = rand(1000, 9999);


        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp' => $otp
        ]);

        Mail::raw('G-' . $otp . ' is your verification code.', function ($message) use ($request) {
            $message->to($request->email)->subject("Email Verification");
        });


        return $this->success(message: 'The OTP has been sent to the email.', code: 201);
    }

    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error(data: ['error' => $validator->errors()]);
        }

        $user = User::where('email', '=', $request->email)->first();
        if ($user == null) {
            return $this->error(message: 'user not found', code: 404);
        }

        if ($user->email_verified_at != null) {
            return $this->error(message: 'The email has already been verified', code: 404);
        }


        $otp = rand(1000, 9999);
        Mail::raw('G-' . $otp . ' is your verification code.', function ($message) use ($otp, $request) {
            $message->to($request->email)->subject("Email Verification");
        });
        $user->otp = $otp;
        $user->save();
        return $this->success(message: 'The OTP has been sent to the email.', code: 201);
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error(data: ['error' => $validator->errors()]);
        }

        $user = User::where('email', '=', $request->email)->first();
        if ($user == null) {
            return $this->error(message: 'user not found', code: 404);
        }

        if ($user->email_verified_at != null) {
            return $this->error(message: 'The email has already been verified', code: 404);
        }

        if ($user->otp == $request->otp) {
            $user->email_verified_at = now();
            $res = [
                'token' => $user->createToken('APPLICATION')->accessToken,
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'id' => $user->id,
            ];
            $user->save();
            return $this->success(data: $res, message: 'Your email verified.', code: 201);
        } else {
            return $this->error(message: 'invalid OTP, try again', code: 403);
        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error(data: ['error' => $validator->errors()]);
        }

        $user = User::find($id);
        if ($user == null) {
            return $this->error(message: 'user not found', code: 404);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;

        $user->save();

        return $this->success(message: 'user updated successfully', code: 202);
    }


    /**
     * login user to our application
     */
    public function login(Request $request)
    {
        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            if ($user->email_verified_at == null) {
                Auth::logout();
                return $this->error(message: 'Please verify your email first' , code: 202) ;
            }
            $token = $user->createToken('APPLICATION')->accessToken;
            return $this->success(data: ['token' => $token, 'user_name' => $user->first_name . ' ' . $user->last_name]);
        } else {
            return $this->error(code: 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\user $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id)
    {
        $user = User::find($id);
        if ($user == null)
            return $this->error(message: 'user not found', code: 404);
        return $this->success(data: $user);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\user $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $user = User::find($id);
            if ($user == null) {
                return $this->error(message: 'user doesn\'t exist.', code: 404);
            }

            $result = $user->delete();
            if ($result)
                return $this->success(message: 'user deleted successfully.');
            else
                return $this->error(message: 'can\'t delete the user.', code: 403);
        } catch (e) {
            return $this->error(message: 'can\'t delete the user.', code: 403);
        }
    }

    public function assignProducts($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            return $this->error(message: 'user not found', code: 404);
        }
        $productsId = $request->product == null ? [] : $request->product;
        $total = 0;
        foreach ($productsId as $productId) {
            $productId = (int)($productId);
            $product = Product::find($productId);
            $userProduct = UserProducts::where('user_id', $id)->where('product_id', $productId)->get();
            if ($product != null && count($userProduct) == 0) {
                $userProduct = new UserProducts([
                    'user_id' => $id,
                    'product_id' => $productId,
                ]);
                $userProduct->save();
                $total += 1;
            }
        }
        return $this->success(message: 'Total of ' . $total . ' products assigned successfully', code: 201);
    }

}
