<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class UserController extends Controller
{
    public function showUserName(){
        return 'Ashraf Hashem';
    }

    public function getIndex(){
        /*$data=[];
        $data['id']=28;
        $data['name']='Ashraf Hashem';
        return view('aa',$data);*/
        $obj=new \stdClass();
        $obj->name='Ashraf';
        $obj->id=5;
        $obj->gender='male';
        //$data=['Ahmed','Ashraf'];
        $data=[];
        //return view('layouts/master',compact('obj'));
        //return view('aa')->with('name','Ashraf Hashem');
        return view('aa',compact('data'));

    }
}
