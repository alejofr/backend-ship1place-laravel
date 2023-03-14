<?php

namespace App\Http\Controllers;

use App\Helpers\IsValidChange;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\StoreUserSubClientRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\RecoverPassword;
use App\Services\CityService;
use App\Services\CountryService;
use App\Services\Log\CreateLogRequest;
use App\Services\ProvinceService;
use App\Services\RoleService;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
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

    public function index(Request $request)
    {
       return $this->successResponse($this->userService->index($request->limit, $request->page, $request->search, $request->country_id, $request->province_id, $request->city_id));
    }

    public function search(Request $request)
    {
        return $this->successResponse($this->userService->searchUser($request->search, $request->country_id, $request->province_id, $request->city_id));
    }
    public function storeSubClient(StoreUserSubClientRequest $request)
    {
        $this->countryService->showCountry($request->country_id);
        $this->provinceService->showPronvince($request->province_id);
        $this->cityService->showCity($request->city_id);

        $user = $this->userService->storeUser('sub-client', $request->all());
        $user = RoleService::assing(3, 'api', $user);

        return $this->successResponse($user);
    }

    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userService->showUser($id);

        if(  IsValidChange::compare($request->country_id, $user->country_id)  ){
            $this->countryService->showCountry($request->country_id);
        }

        if(  IsValidChange::compare($request->province_id, $user->province_id)  ){
            $this->provinceService->showPronvince($request->province_id);
        }

        if(  IsValidChange::compare($request->city_id, $user->city_id)  ){
            $this->cityService->showCity($request->city_id);
        }

        if( $user->getRoleNames()->first() != 'SubClient' && $request->user_id_parent != null ){
            return $this->errorResponse('This user cannot be assigned a user ID '.$request->user_id_parent.'', Response::HTTP_UNAUTHORIZED);
        }

        if( $user->getRoleNames()->first() == 'SubClient' && IsValidChange::compare($request->user_id_parent, $user->user_id_parent) ){
            $this->userService->showUser($request->user_id_parent);
        }

        if( IsValidChange::compare($request->email, $user->email) && $this->userService->isEmail($request->email)){
            return $this->errorResponse('The email has already been taken.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $log = new CreateLogRequest('update', $user);

        $user->fill($request->all());

        if( $user->isClean() ){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->update();
        $log->createLog($user);

        return $this->successResponse($user);
    }

    public function destroy($id)
    {
        $user = $this->userService->showUser($id);
        $log = new CreateLogRequest('delete', $user);

        if( $user->getRoleNames()->first() == 'Client' ){
            $this->userService->deleteSubClients($user->user_id);
        }

        $user->delete();
        $log->createLog();
        
        return $this->successResponse($user);   
    }

    public function disableUser($id)
    {
        $user = $this->userService->showUser($id);
        $log = new CreateLogRequest('delete', $user);

        if( $user->getRoleNames()->first() == 'Client' ){
            $this->userService->disableSubClients($user->user_id);
        }

        $user->status = false;

        $user->update();
        $log->createLog($user);

        return $this->successResponse($user);  
    }

    public function recoverPassword(EmailRequest $request)
    {
        $user = $this->userService->getUserForEmail($request->email);

        if( $user == null ){
            return $this->errorResponse('Sorry the email is not registered', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $log = new CreateLogRequest('delete', $user);

        $newPassword = $this->userService->generatePassword();
        
        Mail::to($user->email)
        ->send(new RecoverPassword($newPassword));

        $user->password = $this->userService->generate_bcrypt_password($newPassword);
        $user->change_password = true;

        $user->update();
        $log->createLog($user);
        
        return $this->successResponse('The new password has been sent to the email');  
    }

    public function changePassword(PasswordRequest $request)
    {
        $user = $this->userService->showUser($request->user()->user_id);
        $user->password = $this->userService->generate_bcrypt_password($request->password);

        $user->update();

        return $this->successResponse($user);
    }
}
