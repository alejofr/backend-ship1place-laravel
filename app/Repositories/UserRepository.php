<?php 

namespace App\Repositories;

use App\Models\User;

class UserRepository{
    public $modelo;
    public $search;

    public function user($select = ['*']) 
    {
        return $this->modelo = User::select($select);
    }

    public function queryRelation($field, $value)
    {
        $this->modelo->where($field, '=', $value);
    }
    public function query($query)
    {
        $this->search = $query;

        $this->modelo = $this->modelo->Where(function($query) {
            $query->orWhere('first_name',  'LIKE', '%'.$this->search.'%')
            ->orWhere('last_name',  'LIKE', '%'.$this->search.'%')
            ->orWhere('email',  'LIKE', '%'.$this->search.'%');
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
    public function createUser($UserData): User
    {
        return User::create($UserData);
    }

    public function getUser($user) : User
    {
        return User::findOrFail($user);
    }

    public function checkEmail($email) : User | null
    {
        return User::where('email', '=', $email)->first();
    }

    public function updateUser($user, $UserData)
    {
        $user = $this->getUser($user);

        $user->fill($UserData);

        if( $user->isClean() ){
            return 'FAILCHANGEFALSE';
        }

        $user->update();
        
        return $user;
    }

    public function deleteUsers($field, $value) 
    {
        User::where($field, '=', $value)->delete();
    }

    public function disableUsers($field, $value)
    {
        User::where($field, '=', $value)->update(['status' => false]);
    }
}
