<?php

namespace App\Http\Controllers;

use App\Partner;
use App\PartnerType;
use App\User;
use App\GetUserGroup;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{

    protected  $location ;

    public function __construct()
    {
        $this->location =['Abu Dhabi' , 'Dubai' , 'Sharjah' , 'Ajman' ,'Umm Al Quwain','Ras Al Khaimah' ,'Fujairah' ];
    }


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

            $profile->location = $partner->location = array_search($partner['location'],$this->location);
            

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

        $request->validate([
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,'.$id,
            'avatar' =>'image|mimes:jpeg,png,jpg,gif',

            ],
                ['password.regex' => 'Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). ',
                    'username.regex' => 'Username not allowing space',
                ]);

        if(Auth::user()->user_group_id == 2 ){
            Partner::where('id', Auth::user()->partner_id)->update(array(
                'first_name' => request('first_name'),
                'last_name' => request('last_name'),
                'location' => $this->location[$request->location],
            ));
        }

        $data = array(
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email')
        );

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time(). '.' . $avatar->getClientOriginalExtension();
            //Image::configure(array('driver' => 'imagick'));
            Image::make($avatar)->resize(300, 300)->save( public_path('/upload/avatars/'.$filename));
            
            if(Auth::user()->isPartner()){
                Image::make($avatar)->resize(300, 300)->save( public_path('/upload/partners/'.$filename));
                Partner::where('id', Auth::user()->partner->id)->update(['logo'=> '/upload/partners/' . $filename]);
            }
            $data['avatar'] = 'upload/avatars/' . $filename;
        }
        if(isset($request->password)){
            $data['password'] = bcrypt(request('password'));
        }
        User::where('id',Auth::user()->id)->update($data);

        return redirect(route("profile.index"));
    }
}
