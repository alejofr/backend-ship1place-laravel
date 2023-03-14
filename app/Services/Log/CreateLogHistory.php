<?php 

namespace App\Services\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use ZipArchive;

class CreateLogHistory{
    public $file;
    public $fileName;

    public function __construct()
    {
        $this->file = 'controlRequests.log';
        $this->fileName = Carbon::now()->format('Y-m-d').'.zip';
    }

    private function createZip()
    {
        $zip = new ZipArchive();
        
        if ($zip->open(storage_path('app/public/'.$this->fileName), ZipArchive::CREATE) === TRUE)
        {
            $files = File::files(storage_path('app/public/log'));

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();

            return true;
        }else{
            return false;
        }
    }

    public function create()
    {
        
        if( $this->createZip() == true ){
            storage_path('app/public/'.$this->fileName);
            return true;
        }

        return false;
    }
}