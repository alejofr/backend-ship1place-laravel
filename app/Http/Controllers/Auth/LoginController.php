<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Services\AuthSactumService;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{   
    
    use ApiResponse;
    private $userService;

    public function __construct(UserService $userService)
    {
       $this->userService =  $userService;
    }
    public function login(LoginUserRequest $request)
    {
        if(!Auth::attempt($request->only('email', 'password')) ){
            return $this->errorResponse('These credentials do not match our records.', Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->userService->loginDateTime($request->user());

        return $this->successResponse(AuthSactumService::generate($user));
    }
}
