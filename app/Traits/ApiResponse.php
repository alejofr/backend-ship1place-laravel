<?php 

namespace App\Traits;

use Illuminate\Http\Response;

/**
 * 
 */
trait ApiResponse
{
    /**
     * Build a success response
     * @param string|array $data
     * @param int $code
     * @return Illuminate\Http\JSONResponse
     */

    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Build a error response
     * @param string $message
     * @param int $code
     * @return Illuminate\Http\JSONResponse
     */

    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}