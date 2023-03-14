<?php 

namespace App\Services\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CreateLogRequest{

    public $dataLog = [];

    public function __construct($typeLog, $beforeChange)
    {

        $this->dataLog = [
            'date_created' => Carbon::now(),
            'type' => $typeLog,
            'before_change' => json_decode($beforeChange)
        ];
    }

    public function createLog($afterChange = null)
    {
        $this->dataLog['after_change'] = $afterChange != null ? json_decode($afterChange) : null;

        Log::channel('controlRequests')->info(json_encode($this->dataLog));
    }
}
