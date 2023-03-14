<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'country_id';
    protected $fillable = [
        'name',
        'code',
        'phone_code'
    ];

    protected $table = 'countries';

    public function province() { return $this->hasMany('App\Models\Province', 'country_id', 'country_id'); }
    public function city() { return $this->hasMany('App\Models\City', 'country_id', 'country_id'); }
}
