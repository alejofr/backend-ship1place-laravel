<?php


namespace App\Traits;

trait RulesCountry{
    public function rulesCountry()
    {
        return [
            'name' => ['max:120'],
            'code' => ['max:40'],
            'phone_code' => ['max:40']
        ];
    }

    public function isRequiredCountry($data = [])
    {
        $newData = [];

        foreach ($data as $key => $value) {
            $rules = [...$value];

            if( $key == 'name' || $key == 'code' ){
                array_push($rules, 'unique:countries');
            }
            
            $newData[$key] = [ 'required', ...$rules];
        }

        return $newData;
    }
}