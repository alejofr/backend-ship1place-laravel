<?php 

namespace App\Services\Log;

use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ShowLogHistory{
    public static $path;
    public static function isZip($date){
        self::$path = 'public/'.$date.'.zip';

        if( Storage::exists(self::$path) ){
            return true;
        }

        return false;
    }

    public static function unZip(){
        $zip = new ZipArchive();

        if( $zip->open(Storage::path(self::$path)) ){

            if( Storage::exists('public/controlRequests.log') ){
                self::deleteFile();
            }

            $zip->extractTo(storage_path('app/public'));
            $zip->close();

            return true;
        }else{
            return false;
        }
    }

    public static function deleteFile(){
        Storage::disk('public')->delete('controlRequests.log');
    }
}