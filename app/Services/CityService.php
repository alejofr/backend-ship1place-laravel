<?php

namespace App\Services;

use App\Models\City;
use App\Repositories\CityRepository;

class CityService{

    private $cityRepository;
    public $fields = [
        'cities.city_id',
        'cities.name',
        'provinces.province_id',
        'provinces.name AS province_name',
        'provinces.code AS province_code',
        'countries.country_id',
        'countries.name AS country_name',
        'countries.code AS country_code',
        'countries.phone_code AS country_phone_code'
    ];
    public function __construct(CityRepository $cityRepository)
    {
       $this->cityRepository =  $cityRepository;
    }
    public function showCity($id) : City
    {
        return $this->cityRepository->getCity($id);
    }

    public function index($limit, $page, $query = null)
    {
        $this->cityRepository->city($this->fields);
        $this->cityRepository->leftJoin('provinces', 'provinces.province_id', 'cities.province_id');
        $this->cityRepository->leftJoin('countries', 'countries.country_id', 'cities.country_id');

        $limit = $limit != null ? $limit : 30;
        $page = $page != null ? $page : 1;
        
        if( $query != null ){
            $this->cityRepository->query($query);
        }

        $count = $this->cityRepository->count();
        $this->cityRepository->limit($limit, $page);
        $results = $this->cityRepository->all();

        return [
            'cities' => $results,
            'pagination' => [
                'numPage' => intval($page),
                'resultPage' => count($results),
                'totalResult' => $count
            ]
        ];
    }

    public function searchCity($query = null, $country_id = null, $province_id = null)
    {
        $results = [];
        $this->cityRepository->city([$this->fields[0], $this->fields[1]]);
        $this->cityRepository->leftJoin('provinces', 'provinces.province_id', 'cities.province_id');
        $this->cityRepository->leftJoin('countries', 'countries.country_id', 'cities.country_id');

        if( $country_id != null ){
            $this->cityRepository->queryRelation('countries.country_id', $country_id);
        }

        if( $province_id != null ){
            $this->cityRepository->queryRelation('provinces.province_id', $province_id);
        }

        if( $query != null ){
            $this->cityRepository->query($query);
        }

        $results = $this->cityRepository->all();

        return $results;
    }

    public function storeCity($dataCity) : City
    {
        return $this->cityRepository->createCity($dataCity);
    }

    public function isNameCity($value) : bool
    {
        return $this->cityRepository->isCheckValue('name', $value) == null ? false : true;
    }
}
