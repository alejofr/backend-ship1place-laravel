<?php 

namespace App\Repositories;

use App\Models\Country;

class CountryRepository{

    public $modelo;
    public $search;
    public function country($select = ['*'])
    {
        return $this->modelo = Country::select($select);
    }

    public function query($query)
    {
        $this->search = $query;

        $this->modelo = $this->modelo->Where(function($query) {
            $query->orWhere('name',  'LIKE', '%'.$this->search.'%')
            ->orWhere('code',  'LIKE', '%'.$this->search.'%')
            ->orWhere('phone_code',  'LIKE', '%'.$this->search.'%');
        });
    }

    public function limit($limit = 30, $page = 1)
    {
        $this->modelo->limit($limit)
        ->skip($limit * ($page - 1));
    }

    public function count() : int
    {
       return $this->modelo->count();
    }

    public function all()
    {
       return $this->modelo->get()->toArray();
    }

    public function createCountry($CountryData): Country
    {
        return Country::create($CountryData);
    }

    public function getCountry($Country) : Country
    {
        return Country::findOrFail($Country);
    }

    public function isCheckValue($field, $value) : Country | null
    {
        return Country::where($field, '=', $value)->first();
    }
}