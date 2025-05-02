<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    /**
     * Gets the user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserInfo(Request $request)
    {
        $user = $request->user();
        $data['user'] = $user->makeHidden(['id']);
        $response = [
            'status' => 'success',
            'data' => $data
        ];

        return response()->json($response, 200);
    }
}