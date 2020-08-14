<?php

namespace App\Http\Controllers;

use App\Events\VideoViewer;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Models\video;
use App\Scopes\OfferScopes;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Formatter\OutputFormatter;
use LaravelLocalization;

class CrudController extends Controller
{
    use OfferTrait;
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

        //save photo in folder
        $file_name=$this->saveImage($request->photo,'images/offers');

        //insert
        Offer::create([
            'photo' => $file_name,
           'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,     // Mutators     //strtoupper($request->name_en)
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
        $offers = Offer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','price','photo','details_'.LaravelLocalization::getCurrentLocale().' as details'
        )->get();
        return view('offers.all',compact('offers'));
    }

    ################### Paginate Result ##########################

    public function getAllOffersPage()
    {
        $offers = Offer::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','price','photo','details_'.LaravelLocalization::getCurrentLocale().' as details'
        )->paginate(PAGINATION_COUNT);

        return view('offers.pagination',compact('offers'));
    }

    #######################################################

    public function editOffer($offer_id)
    {
        //Offer::findOrFail($offer_id);
        $offer=Offer::find($offer_id); //search in given table id table
        if(!$offer)
            return redirect()->back();

        $offer=Offer::select('id','name_ar','name_en','price','details_ar','details_en')->find($offer_id);
        return view('offers.edit',compact('offer'));

        //return $offer_id;
    }

    public function deleteOffer($offer_id)
    {
        $offer = Offer::find($offer_id);  //  Offer::where('id','$offer_id')->first();  //Offer::where('id','>=','$offer_id')->first();
        if(!$offer)
            return redirect()->back()->with(['error'=>__('messages.offer not exist')]);

        $offer->delete();
        return redirect()->route('offers.all')->with(['success'=>__('messages.offer deleted successfully')]);
    }

    public function updateOffer(OfferRequest $request,$offer_id)
    {
        $offer=Offer::select('id','name_ar','name_en','price','details_ar','details_en')->find($offer_id);
        if(!$offer)
            return redirect()->back();

        $offer->update($request->all());
        /*$offer->update([
           'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'price'=>$request->price,
            'details_ar'=>$request->details_ar,
            'details_en'=>$request->details_en,
        ]);*/
        return redirect()->back()->with(['success'=>'تم التحديث بنجاح']);

    }

    public function getVideo()
    {
        $video = video::first();
        event(new VideoViewer($video));  //fire event
        return view('video')->with('video',$video);
    }


    public function getAllInactiveOffers()
    {
        //  where  whereNull  whereNotNull  whereIn
        //Offer::whereNotNull('details_ar')->get();

        //return $inactiveoffers = Offer::inactive()->get(); // local scope
        //return $inactiveoffers = Offer::Invalid()->get();  // local scope

        //return $inactiveoffers = Offer::get(); // global scope

              // how to remove global scope
        return $offer = Offer::withoutGlobalScope(OfferScopes::class)->get();


    }

}
