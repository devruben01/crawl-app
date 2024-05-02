<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Login a user and return a JWT token
     *
     * @OA\Post(
     *     path="/login",
     *     tags={"Users"},
     *     summary="Login",
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="demo")
     *             )
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                  @OA\Property(property="access_token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI..."),
     *                  @OA\Property(property="token_type", type="string", example="bearer"),
     *                  @OA\Property(property="expires_in", type="int", example=3600),
     *              ),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="You are successfully logged in"),
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The email or password is incorrect. Try again"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The password field is required."),
     *         ),
     *      ),
     * )
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        $token = auth()->attempt($credentials);
        if (!$token) {
            return $this->responseCustom(null, 401, false, trans('auth.login_failed'));
        }

        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return $this->responseCustom($data, 200, true, trans('auth.login_successful'));
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *      path="/logout",
     *      summary="Logout",
     *      description="Logout user and invalidate token",
     *      operationId="authLogout",
     *      tags={"Users"},
     *      security={{ "apiAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="You are successfully logged out"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Returns when user is not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="NULL", example=null),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         ),
     *      )
     * )
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return $this->responseCustom(null, 200, true, trans('auth.logout_successful'));
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return response()->json([
            'data' => $data,
            'code' => Response::HTTP_OK,
            'status' => true,
            'message' => 'You are successfully logged in',
        ]);
    }
}
