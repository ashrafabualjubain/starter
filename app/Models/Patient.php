<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table="patients";
    protected $fillable=['name','age'];
    //protected $hidden=['created_at','updated_at'];
    public $timestamps=false;


    //has one through
    public function doctor()            // هذا المريض لديه علاقة مع المريض
    {
        return $this->hasOneThrough('App\Models\Doctor','App\Models\Medical','patient_id','medical_id','id','id');
    }
}
