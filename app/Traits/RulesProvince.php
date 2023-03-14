<?php


namespace App\Traits;

trait RulesProvince{
    public function rulesProvince()
    {
        return [
            'name' => ['max:120'],
            'code' => ['max:40'],
            'country_id' => ['integer']
        ];
    }

    public function isRequiredProvince($data = [])
    {
        $newData = [];

        foreach ($data as $key => $value) {
            $rules = [...$value];

            if( $key == 'name' || $key == 'code' ){
                array_push($rules, 'unique:provinces');
            }

            $newData[$key] = [ 'required', ...$rules];
        }

        return $newData;
    }
}