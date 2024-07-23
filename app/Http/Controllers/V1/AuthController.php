<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\V1\User;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->create($data);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $token = auth()->attempt($data);

        if(!$token) return response()->json(['error' => 'Неверный логин или пароль'], 401);

        return $this->respondWithToken($token);
    }


    /**
     * @return UserResource|JsonResponse
     */
    public function user()
    {
        try {

            return new UserResource(auth('api')->user());

        } catch (TokenExpiredException $e) {

            return response()->json(['error' => 'Token has expired'], 401);

        } catch (TokenInvalidException $e) {

            return response()->json(['error' => 'Token is invalid'], 401);

        } catch (JWTException $e) {

            return response()->json(['error' => 'JWT error'], 401);

        }
    }


    /**
     * @return JsonResponse
     */
    public function logout()
    {
        try {

            auth('api')->invalidate(true);

            auth('api')->logout();

            return response()->json(['msg' => 'Успешный выход']);

        } catch (TokenExpiredException $e) {

            return response()->json(['error' => 'Токен истек'], 401);

        } catch (TokenInvalidException $e) {

            return response()->json(['error' => 'Токен неверный'], 401);

        } catch (JWTException $e) {

            return response()->json(['error' => 'Ошибка JWT'], 401);
        }
    }


    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }


    /**
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
