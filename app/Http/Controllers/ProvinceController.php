<?php

namespace App\Http\Controllers;

use App\Helpers\IsValidChange;
use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Services\CountryService;
use App\Services\ProvinceService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProvinceController extends Controller
{
    use ApiResponse;
    private $provinceService;
    private $countryService;


    public function __construct(ProvinceService $provinceService, CountryService $countryService)
    {
       $this->provinceService = $provinceService;
       $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
       return $this->successResponse($this->provinceService->index($request->limit, $request->page, $request->search));
    }

    public function search(Request $request)
    {
        return $this->successResponse($this->provinceService->searchProvince($request->search, $request->country_id));
    }

    public function store(StoreProvinceRequest $request)
    {
        $this->countryService->showCountry($request->country_id);
        
        return $this->successResponse($this->provinceService->storeProvince($request->all()));
    }

    public function show($id)
    {
        return $this->successResponse($this->provinceService->showPronvince($id));
    }

    public function update($id, UpdateProvinceRequest $request)
    {
        $province = $this->provinceService->showPronvince($id);

        if(  IsValidChange::compare($request->country_id, $province->country_id)  ){
            $this->countryService->showCountry($request->country_id);
        }

        if(  IsValidChange::compare($request->name, $province->name) && $this->provinceService->isNameProvince($request->name) ){
            return $this->errorResponse('The name has already been taken.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(  IsValidChange::compare($request->code, $province->code) && $this->provinceService->isCodeProvince($request->code) ){
            return $this->errorResponse('The code has already been taken.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $province->fill($request->all());

        if( $province->isClean() ){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $province->update();

        return $this->successResponse($province);
    }

    public function destroy($id)
    {
        $province = $this->provinceService->showPronvince($id);
        $province->delete();

        return $this->successResponse($province);
    }
}
