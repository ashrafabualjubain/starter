<?php

namespace App\Models;

use App\Scopes\OfferScopes;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table="offers";
    protected $fillable=['name_ar','name_en','price','details_ar','details_en','photo','status','created_at','updated_at'];
    protected $hidden=['created_at','updated_at'];
    //public $timestamps=false;


    // register global scope
        public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new OfferScopes);
    }

    ######################################### Local Scopes #######################################
    public function scopeInactive($query)
    {
        return $query->where('status',0);

    }

    public function scopeInvalid($query)
    {
        return $query->where('status',0)->whereNull('details_ar');

    }

    #############################################################################################

    ################################# Mutators ####################################

    public function setNameEnAttribute($value)    // NameEn => name_en
    {
        return $this -> attributes['name_en'] = strtoupper($value);  // save in database with letters of upper case يحول الأحرف الى أحرف كبيرة
    }

}
