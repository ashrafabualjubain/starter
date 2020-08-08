<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Formatter\OutputFormatter;
use LaravelLocalization;

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

    public function store(OfferRequest $request)
    {
        //Validate data before insert to database
        /*$rules=$this->getRules();
        $messages=$this->getMessages();
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            //return $validator->errors();
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }*/

        //insert
        Offer::create([
           'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
           'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
        ]);
        //return 'Saved successfully';
        return redirect()->back()->with(['success'=>'تم اضافة العرض بنجاح']);
    }

    /*protected function getRules()
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
            'name.required' => __('messages.offer name required'),
            'name.unique' => __('messages.offer name must be unique'),
            'price.numeric' => 'سعر العرض يجب أن يكون أرقام',
            'price.required' => __('messages.offer price required'),
            'details.required' => __('messages.offer details required'),
        ];
    }*/

    public function getAllOffers()
    {
        $offers = Offer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','price','details_'.LaravelLocalization::getCurrentLocale().' as details')->get();
        return view('offers.all',compact('offers'));
    }
}
