<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class CollectTut extends Controller
{

    public function index()
    {
        /*$numbers = [1,2,3,3];
        $col = collect($numbers);
        //return $col->avg();
        //$col->count();      // عدد عناصر المصفوفة
        //$col->countBy();   // بيجيب كل عنصر كم مرة تكرر بمعنى رقم 3 تكرر مرتين
        //$col->duplicates();
        //each()
        //filter()
        //search()
        //transform()
        return $col;*/

        $names = collect(['name','age']);
        return $res = $names->combine(['Ahmad','25']);          // this means=>   name: "Ahmad"   ,   age: 25

    }

    public function complex()
    {
        $offers = Offer::get();

        //remove
        $offers -> each(function($offer) {
            if($offer -> status == 0)
            {
                unset($offer->details_en);    // delete    تحذف هذا الحقل من العرض على الشاشة
                unset($offer->details_ar);
            }
            $offer -> name = 'windows';      // add   يضيف هذا الحقل البيانات التي تعرض على الشاشة
            return $offer;
        });
        return $offers;
    }

    public function complexFilter()
    {
        $offers = Offer::get();
        $offers = collect($offers);
        $ersultOfFilter = $offers->filter(function ($value,$key){
           return $value['name_en'] == 'chooses';
        });
        return array_values($ersultOfFilter->all());
    }

    public function complexTransform()
    {
        $offers = Offer::get();
        $offers = collect($offers);
        return $ersultOfFilter = $offers->transform(function ($value,$key){
            $data = [];
            $data['name'] = $value['name_en'];
            $data['age'] = 30;
            return $data;
            //return 'name is : '.$value['name_en'];
        });
    }
}
