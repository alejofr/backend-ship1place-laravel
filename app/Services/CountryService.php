<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\CountryRepository;

class CountryService{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
       $this->countryRepository =  $countryRepository;
    }
    public function showCountry($id) : Country
    {
        return $this->countryRepository->getCountry($id);
    }

    public function index($limit, $page, $query = null)
    {
        $this->countryRepository->country();
        $limit = $limit != null ? $limit : 30;
        $page = $page != null ? $page : 1;
        
        if( $query != null ){
            $this->countryRepository->query($query);
        }

        $count = $this->countryRepository->count();
        $this->countryRepository->limit($limit, $page);
        $results = $this->countryRepository->all();

        return [
            'countries' => $results,
            'pagination' => [
                'numPage' => intval($page),
                'resultPage' => count($results),
                'totalResult' => $count
            ]
        ];
    }

    public function searchContry($query = null)
    {
        $results = [];
        $this->countryRepository->country();

        if( $query != null ){
            $this->countryRepository->query($query);
            $results = $this->countryRepository->all();
        }

        return $results;
    }

    public function storeCountry($dataCountry) : Country
    {
        return $this->countryRepository->createCountry($dataCountry);
    }

    public function isNameCountry($value) : bool
    {
        return $this->countryRepository->isCheckValue('name', $value) == null ? false : true;
    }
    public function isCodeCountry($value) : bool
    {
        return $this->countryRepository->isCheckValue('code', $value) == null ? false : true;
    }
}
