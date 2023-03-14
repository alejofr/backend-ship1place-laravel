<?php


namespace App\Traits;

trait RulesCity{
    public function rulesCity()
    {
        return [
            'name' => ['max:120'],
            'country_id' => ['integer'],
            'province_id' => ['integer'],
        ];
    }

    public function isRequiredCity($data = [])
    {
        $newData = [];

        foreach ($data as $key => $value) {
            $rules = [...$value];

            if( $key == 'name'){
                array_push($rules, 'unique:cities');
            }

            $newData[$key] = [ 'required', ...$rules];
        }

        return $newData;
    }
}