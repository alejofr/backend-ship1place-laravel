<?php

namespace App\Traits;

trait RulesStoreUser{
    public function rulesUser()
    {
        return [
            'first_name' => ['max:40'],
            'last_name' => ['max:40'],
            'email' => ['email'],
            'password' => ['max:15'],
            'phone' => ['max:20'],
            'address' => ['max:255'],
            'country_id' => ['integer'],
            'province_id' => ['integer'],
            'city_id' => ['integer'],
            'consent_to_receive_newsletter' => ['boolean'],
            'business' => ['boolean'],
        ];
    }

    public function isRequiredUser($data = [])
    {
        $newData = [];

        foreach ($data as $key => $value) {
            $rules = [...$value];

            if( $key == 'email' ){
                array_push($rules, 'unique:users');
            }

            $newData[$key] = [ 'required', ...$rules];
        }

        return $newData;
    }

    public function ruleIsIdUser()
    {
        return [
            'user_id_parent' => ['integer'],
        ];
    }
}