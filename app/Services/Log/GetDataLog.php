<?php 

namespace App\Services\Log;

use Illuminate\Support\Facades\Storage;

class GetDataLog{
    public $file;
    public $path;

    public function __construct($nameFile)
    {
        $this->path = Storage::path($nameFile);
    }

    private function openFile()
    {
        $this->file = fopen($this->path,"r");
    }
    private function generateDataFile()
    {
        $data = [];
        $dataPrint = [];

        while (!feof($this->file)) {
            $l = fgets($this->file);
            $s = nl2br($l);
            array_push($data, $s);
        }
       

        for ($i=0; $i <count($data) ; $i++) { 
            $arrayAux = explode('local.INFO:', $data[$i]);
            if( count($arrayAux) >= 2 ){
                $text = preg_replace('/[\r\n|\n|\r]+/',"", $arrayAux[1]);
                $text = preg_replace('<br />',"", $text);
                $arrAux = explode(' <>', $text);
                array_push($dataPrint, rtrim($arrAux[0]));
            }
        }

        return $dataPrint;
    }

    public function get() : Array
    {
        $this->openFile();
        $data = $this->generateDataFile();

        return $data;
    }

    public function getJsonDecode()
    {
        $data = $this->get();
        $dataAux = [];

        for ($i=0; $i < count($data) ; $i++) { 
            array_push($dataAux, json_decode($data[$i]));
        }

        return $dataAux;
    }

}