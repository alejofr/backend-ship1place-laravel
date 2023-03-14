<?php 

namespace App\Repositories;

use App\Models\City;

class CityRepository{

    public $modelo;
    public $search;
    public function city($select = ['*'])
    {
        return $this->modelo = City::select($select);
    }

    public function leftJoin($nameTable, $id, $idCompare)
    {
        $this->modelo->leftJoin($nameTable, $id, $idCompare);
    }

    public function queryRelation($field, $value)
    {
        $this->modelo->where($field, '=', $value);
    }
    public function query($query)
    {
        $this->search = $query;

        $this->modelo = $this->modelo->Where(function($query) {
            $query->orWhere('cities.name',  'LIKE', '%'.$this->search.'%');
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
    public function createCity($CityData): City
    {
        return City::create($CityData);
    }

    public function getCity($City) : City
    {
        return City::findOrFail($City);
    }

    public function isCheckValue($field, $value) : City | null
    {
        return City::where($field, '=', $value)->first();
    }
}