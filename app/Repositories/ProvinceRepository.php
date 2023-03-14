<?php 

namespace App\Repositories;

use App\Models\Province;

class ProvinceRepository{

    public $modelo;
    public $search;
    public function province($select = ['*'])
    {
        return $this->modelo = Province::select($select);
    }

    public function leftJoinCountry()
    {
        $this->modelo->leftJoin('countries', 'countries.country_id', 'provinces.country_id');
    }

    public function queryIdCountry($value)
    {
        $this->modelo->where('countries.country_id', '=', $value);
    }

    public function query($query)
    {
        $this->search = $query;

        $this->modelo = $this->modelo->Where(function($query) {
            $query->orWhere('provinces.name',  'LIKE', '%'.$this->search.'%')
            ->orWhere('provinces.name',  'LIKE', '%'.$this->search.'%');
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
    public function createProvince($ProvinceData): Province
    {
        return Province::create($ProvinceData);
    }

    public function getProvince($Province) : Province
    {
        return Province::findOrFail($Province);
    }

    public function updateProvince($Province, $ProvinceData)
    {
        $Province = $this->getProvince($Province);

        $Province->fill($ProvinceData);

        if( $Province->isClean() ){
            return 'FAILCHANGEFALSE';
        }

        return $Province;
    }

    public function deleteProvince($Province) : Province
    {
        $Province = $this->getProvince($Province);
        $Province->delete();

        return $Province;
    }

    public function isCheckValue($field, $value) : Province | null
    {
        return Province::where($field, '=', $value)->first();
    }

    public function compareIdCountryAndIdProvince($country_id, $province_id) : Province | null
    {
        return Province::where('country_id', '=', $country_id)->where('province_id', '=', $province_id)->first();
    }
}