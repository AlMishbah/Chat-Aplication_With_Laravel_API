<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telp' => $request->no_telp,
            'avatar' => $request->avatar
        ]);

        $token = auth()->login($user);
        $get = User::where('username', $request->username);
        $id = $get->first();
        return $this->respondWithToken($token, $id->id);
    }

    public function login(Request $request)
    {

        $credentials = $request->only(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $get = User::where('username', $request->username);
        $id = $get->first();

        return $this->respondWithToken($token, $id);
    }

    protected function respondWithToken($token, $id)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,

            'user' => $id
        ]);
    }

    public function index($id)
    {
        return response()->json(User::find($id));
    }

    public function show()
    {
        return response()->json(User::all());
    }

    public function updateAvatar(Request $request)
    {
        $get = User::find($request->id);
        $get->avatar = $request->input('avatar');

        if ($get->save()) {
            return response()->json(['exception' => 'Berhasil']);
        }
        return response()->json(['exception' => 'gagal']);
    }

    // public function updateAvatarMobile(Request $request) {
    //     $get = User::find($request->id);
    // }

    public function updateUser(Request $request)
    {
        $get = User::find($request->id);
        $get->name = $request->input('name');
        $get->email = $request->input('email');
        $get->no_telp = $request->input('no_telp');

        if ($get->save()) {
            return response()->json(['exception' => 'Data Berhasil']);
        }
        return response()->json(['exception' => 'gagal']);
    }

    public function updatePrivate(Request $request)
    { 
        $get = User::find($request->id);
        $get->username = $request->input('username');
        $get->password = bcrypt($request->password);

        if ($get->save()) {
            return response()->json(['exception' => 'Success']);
        }
        return response()->json(['exception' => 'Failed']);

    }
}
