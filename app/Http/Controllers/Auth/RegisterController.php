<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserClientRequest;
use App\Services\AuthSactumService;
use App\Services\CityService;
use App\Services\CountryService;
use App\Services\ProvinceService;
use App\Services\UserService;
use App\Traits\ApiResponse;

class RegisterController extends Controller
{
    use ApiResponse;
    private $userService;
    private $provinceService;

    private $countryService;

    private $cityService;

    public function __construct(UserService $userService, ProvinceService $provinceService, CountryService $countryService, CityService $cityService)
    {
       $this->userService =  $userService;
       $this->provinceService = $provinceService;
       $this->countryService = $countryService;
       $this->cityService = $cityService;
    }

    public function register(StoreUserClientRequest $request)
    {
        $this->countryService->showCountry($request->country_id);
        $this->provinceService->showPronvince($request->province_id);
        $this->cityService->showCity($request->city_id);

        $user = $this->userService->storeUser('client', $request->all());
        $user = $this->userService->loginDateTime($user);

        return $this->successResponse(AuthSactumService::generate($user));
    }
}
