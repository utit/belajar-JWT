<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Facade\FlareClient\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTController extends Controller
{
    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function registrasi(Request $request)
    {
        $daftar = new User();
        $daftar->name = $request->name;
        $daftar->email = $request->email;
        $daftar->password = bcrypt($request->password);
        $daftar->save();


        if ($daftar) {
            return response()->json([
                'success' => true,
                'data' => $daftar
            ], 200);
        }
    }

    public function profil()
    {

        $response = [
            "success" => true,
            "data" => Auth::user()
        ];

        return response()
            ->json($response);
    }
}
