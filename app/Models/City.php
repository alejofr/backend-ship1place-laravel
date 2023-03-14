<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'city_id';
    protected $fillable = [
        'name',
        'province_id',
        'country_id'
    ];

    protected $table = 'cities';

    public function country(){ return $this->belongsTo('App\Models\Country'); }
    public function province(){ return $this->belongsTo('App\Models\Province'); }

}
