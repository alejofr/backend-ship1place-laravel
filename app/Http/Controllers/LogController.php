<?php

namespace App\Http\Controllers;

use App\Http\Requests\DateRequest;
use App\Services\Log\GetDataLog;
use App\Services\Log\ShowLogHistory;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;

class LogController extends Controller
{
    use ApiResponse;
    public function allCurrent()
    {
        $logs = new GetDataLog('public/log/controlRequests.log');
        
        return $this->successResponse($logs->getJsonDecode());
    }

    public function historyLogs(DateRequest $request)
    {
        if( !ShowLogHistory::isZip($request->date) ){
            return $this->errorResponse('No results found', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if( !ShowLogHistory::unZip() ){
            return $this->errorResponse('an unexpected error occurred, try again later.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $logs = new GetDataLog('public/controlRequests.log');

        return $this->successResponse($logs->getJsonDecode());
    }
}
