<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $table="countries";
    protected $fillable=['name'];
    //protected $hidden=['created_at','updated_at'];
    public $timestamps=false;


    public function doctors()
    {
        return $this->hasManyThrough('App\Models\Doctor','App\Models\Hospital','country_id','hospital_id','id','id');
    }
}
