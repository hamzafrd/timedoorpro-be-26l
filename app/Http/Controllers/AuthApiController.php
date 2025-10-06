<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    /**
     * @throws ValidationException
     */
    function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode(', ', $errors);
            return $this->responseJson($errorMessages, 402);
        }

        [
            'username' => $username,
            'password' => $password,
            'email' => $email
        ] = $validator->validated();

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return $this->responseJson("Provided Credentials are incorrect", 402);
        }

        $token = $user->createToken("$username-token")->plainTextToken;
        return $this->responseJson("Success", 200, ['token' => $token]);
    }

    /**
     * @throws ValidationException
     */
    function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'username' => 'required',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode(', ', $errors);
            return $this->responseJson($errorMessages, 402);
        }

        [
            'username' => $username,
            'password' => $password,
            'email' => $email
        ] = $validator->validated();


        User::create([
            'name' => $username,
            'password' => Hash::make($password),
            'email' => $email
        ]);

        return $this->responseJson("User Created Succesfully !", 200, $validator->validated());
    }

    function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return $this->responseJson("Logged Out Succesfully !");
    }

    function failedLoggedIn(): JsonResponse
    {
        return $this->responseJson("Gagal, Authentikasi tidak tepat !", 401);
    }
}
