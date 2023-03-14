<?php

namespace App\Services;

use App\Models\Province;
use App\Repositories\ProvinceRepository;

class ProvinceService{

    private $provinceRepository;
    public $fields = [
        'provinces.province_id',
        'provinces.name',
        'provinces.code',
        'provinces.country_id',
        'countries.name AS country_name',
        'countries.code AS country_code',
        'countries.phone_code AS country_phone_code'
    ];
    public function __construct(ProvinceRepository $provinceRepository)
    {
       $this->provinceRepository =  $provinceRepository;
    }
    public function showPronvince($id) : Province
    {
        return $this->provinceRepository->getProvince($id);
    }

    public function index($limit, $page, $query = null)
    {
        $this->provinceRepository->province($this->fields);
        $this->provinceRepository->leftJoinCountry();

        $limit = $limit != null ? $limit : 30;
        $page = $page != null ? $page : 1;
        
        if( $query != null ){
            $this->provinceRepository->query($query);
        }

        $count = $this->provinceRepository->count();
        $this->provinceRepository->limit($limit, $page);
        $results = $this->provinceRepository->all();

        return [
            'provinces' => $results,
            'pagination' => [
                'numPage' => intval($page),
                'resultPage' => count($results),
                'totalResult' => $count
            ]
        ];
    }

    public function searchProvince($query = null, $country_id = null)
    {
        $results = [];
        $this->provinceRepository->province([$this->fields[0], $this->fields[1], $this->fields[2]]);
        $this->provinceRepository->leftJoinCountry();

        
        if( $country_id != null ){
            $this->provinceRepository->queryIdCountry($country_id);
        }
        if( $query != null ){
            $this->provinceRepository->query($query);
        }

            
        $results = $this->provinceRepository->all();
        

        return $results;
    }

    public function storeProvince($dataProvince) : Province
    {
        return $this->provinceRepository->createProvince($dataProvince);
    }

    public function isNameProvince($value) : bool
    {
        return $this->provinceRepository->isCheckValue('name', $value) == null ? false : true;
    }
    public function isCodeProvince($value) : bool
    {
        return $this->provinceRepository->isCheckValue('code', $value) == null ? false : true;
    }
    public function checkIdCountryAndIdProvince($country_id, $province_id) : bool
    {
        return $this->provinceRepository->compareIdCountryAndIdProvince($country_id, $province_id) == null ? false : true;
    }
}
