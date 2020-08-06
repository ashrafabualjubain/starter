<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function getOffers()
    {
        return Offer::get();
    }

    /*public function store()
    {
        Offer::create([
            'name' => 'offer3',
            'price' => '4000',
            'details' => 'offer3 details',
        ]);

    }*/

    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
    {
        //Validate data before insert to database
        $rules=$this->getRules();
        $messages=$this->getMessages();
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            //return $validator->errors();
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        //insert
        Offer::create([
           'name' => $request->name,
           'price' => $request->price,
           'details' => $request->details,
        ]);
        //return 'Saved successfully';
        return redirect()->back()->with(['success'=>'تم اضافة العرض بنجاح']);
    }

    protected function getRules()
    {
        return $rules=[
            'name' => 'required|max:100|unique:offers,name',
            'price' => 'required|numeric',
            'details' => 'required',
        ];
    }

    protected function getMessages()
    {
        return $messages=[
            'name.required' => 'اسم العرض مطلوب',
            'name.unique' => 'اسم العرض موجود',
            'price.numeric' => 'سعر العرض يجب أن يكون أرقام',
            'price.required' => 'السعر مطلوب',
            'details.required' => 'تفاصيل العرض مطلوب',
        ];
    }
}
