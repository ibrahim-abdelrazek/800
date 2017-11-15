<?php

namespace App\Http\Controllers;

use App\Partner;
use App\PartnerType;
use App\User;
use App\GetUserGroup;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Imagee;

class ProfileController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->user_group_id == 2){

            $partner = Partner::where('id',Auth::user()->partner_id)->first();

            $profile =User::where('id',Auth::user()->id)->first();

            $profile->location = $partner->location;

        }else {
            $profile =User::where('id',Auth::user()->id)->first();
        }


        return view('profile.edit')->with('profile',$profile);

    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        if(Auth::user()->user_group_id = 2 ){

            Partner::where('id', $request->partner_id)->update(array(
                'name' => request('name'),
                'location' => request('location')
            ));


        }
        //dd(Auth::user()->id);

        if(isset($request->password)){


            User::where('id',Auth::user()->id)->update(array(
                'name' => request('name'),
                'username' => request('username'),
                'email' => request('email'),
                'password' => bcrypt(request('password'))
            ));
        } else{
            User::where('id',Auth::user()->id)->update(array(
                'name' => request('name'),
                'username' => request('username'),
                'email' => request('email')
            ));
        }

        return redirect(route("profile.index"));



    }

}
