<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ApiResponse;
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();  

        return $this->successResponse(null);
    }
}
