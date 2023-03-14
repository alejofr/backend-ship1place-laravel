<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\User\StoreClientService;
use App\Services\User\StoreSubClientService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserService{

    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
       $this->userRepository =  $userRepository;
    }

    public function index($limit, $page, $query = null, $country_id = null, $province_id = null, $city_id = null)
    {
        $limit = $limit != null ? $limit : 30;
        $page = $page != null ? $page : 1;

        $this->userRepository->user();

        if( $country_id != null ){
            $this->userRepository->queryRelation('country_id', $country_id);
        }

        if( $province_id != null ){
            $this->userRepository->queryRelation('province_id', $province_id);
        }

        if( $city_id != null ){
            $this->userRepository->queryRelation('city_id', $city_id);
        }

        if( $query != null ){
            $this->userRepository->query($query);
        }

        $count = $this->userRepository->count();
        $this->userRepository->limit($limit, $page);
        $results = $this->userRepository->all();

        return [
            'provinces' => $results,
            'pagination' => [
                'numPage' => intval($page),
                'resultPage' => count($results),
                'totalResult' => $count
            ]
        ];
    }

    public function searchUser($query = null, $country_id = null, $province_id = null, $city_id = null)
    {
        $results = [];
        $this->userRepository->user();

        if( $query != null ){
            if( $country_id != null ){
                $this->userRepository->queryRelation('country_id', $country_id);
            }
    
            if( $province_id != null ){
                $this->userRepository->queryRelation('province_id', $province_id);
            }
    
            if( $city_id != null ){
                $this->userRepository->queryRelation('city_id', $city_id);
            }

            $this->userRepository->query($query);
            $results = $this->userRepository->all();
        }

        return $results;
    }
    public function storeUser($type, $dataUser) : User
    {
        $dataUser['password'] = $this->generate_bcrypt_password($dataUser['password']);

        if( $dataUser['consent_to_receive_newsletter'] ){
            $dataUser['consent_date'] = Carbon::now();
        }

        switch ($type) {
            case 'sub-client':
                return StoreSubClientService::store($dataUser, $this->userRepository);
            default:
                return StoreClientService::store($dataUser, $this->userRepository);
        }
    }
    public function showUser($id) : User
    {
        return $this->userRepository->getUser($id);
    }

    public function isEmail($email) : bool
    {
        return $this->userRepository->checkEmail($email) == null ? false : true;
    }

    public function getUserForEmail($email) : User | null
    {
        return $this->userRepository->checkEmail($email);
    }
    public function generate_bcrypt_password($password)
    {
        return bcrypt($password);
    }

    public function loginDateTime(User $userData)
    {
        $user = $this->userRepository->updateUser($userData->user_id, [
            'last_login' => Carbon::now()
        ]);

        $userData->last_login = $user->last_login;

        return $userData;
    }

    public function deleteSubClients($user_id_parent)
    {
        $this->userRepository->deleteUsers('user_id_parent', $user_id_parent);
    }

    public function disableSubClients($user_id_parent)
    {
        $this->userRepository->disableUsers('user_id_parent', $user_id_parent);
    }

    public function generatePassword() 
    {
        return Str::random(10);
    }
}