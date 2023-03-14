<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'province_id';
    protected $fillable = [
        'name',
        'country_id',
        'code'
    ];

    protected $table = 'provinces';

    public function country(){ return $this->belongsTo('App\Models\Country'); }
    public function city() { return $this->hasMany('App\Models\City', 'province_id', 'province_id'); }
}
