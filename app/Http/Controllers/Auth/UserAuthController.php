<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response(['user' => $user, 'token' => $token, 'message' => 'Registration Successful']);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }
        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details.
            Please try again', ]);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token, 'message' => 'Login Successful']);

    }
}
