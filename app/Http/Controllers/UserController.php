<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\HotelGuest;
use App\Nurse;
use App\Order;
use App\Partner;
use App\PartnerType;
use App\Patient;
use App\Product;
use App\Transaction;
use App\User;
use App\GetUserGroup;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->user_group_id == 1) {

            $users = User::where('user_group_id', '!=', 1)->where('user_group_id', '!=', 2)->get();

        } elseif (Auth::user()->user_group_id == 2) {

            $users = User::where('partner_id', Auth::user()->partner_id)->where('user_group_id', '!=', 2)->get();
        }


        return view('users.index')->with('users', $users);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|min:5|max:50|regex:/^[\pL\s]+$/u',
            'username' => 'required|min:5|max:50|regex:/^\S*$/',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@$#%^&*]).*$/|confirmed',
            'password_confirmation'=>'',
            'user_group_id' => 'required',
            'avatar' =>'required|image|mimes:jpeg,png,jpg,gif',

        ],
            ['password.regex' => 'Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). ',
                'username.regex' => 'Username not allowing space',
            ]);

        if(Auth::user()->isAdmin())
            $request->validate(['partner_id'=> 'required']);


        if (!$request->has('partner_id'))
            $user = array_merge($request->all(), ['partner_id' => Auth::user()->id]);
        else $user = $request->all();

        $user['password'] = Hash::make($user['password']);


        //dd($user);

        if ($userr = User::create($user)){
            if($request->hasFile('avatar')){
                $img = $request->file('avatar');
                $filename = time(). '.' . $img->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($img)->save( public_path('/upload/users/'.$filename));
                $userr->avatar = '/upload/users/'.$filename;
                $userr->save();
                return redirect(route('users.index'));

            }


            // remove old image
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }

        //dd($user);
        return view('users.edit')->with('user', $user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|min:5|max:50|regex:/^[\pL\s]+$/u',
            'username' => 'required|min:5|max:50|regex:/^\S*$/',
            'email' => 'required|unique:users,email,' . $id ,
            'user_group_id' => 'required',
            'avatar' =>'image|mimes:jpeg,png,jpg,gif',
        ]);

        if(Auth::user()->isAdmin())
            $request->validate(['partner_id'=> 'required']);

        if($request->has('password') && !empty($request->password ))
            $request->validate(['password' => 'min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed',
                'password_confirmation'=>''
            ],['password.regex' => 'Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). ']);



        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }

        $data =array();
        $data['name'] = $request->name;
        $data['username'] = $request->username;
        $data['email'] = $request->email;
        $data['user_group_id'] = $request->user_group_id;
        if(Auth::user()->isAdmin())
            $data['partner_id'] = $request->partner_id;
        else
            $data['partner_id'] = Auth::user()->partner_id;

        if (isset($request->password)) {
            $data['password'] = Hash::make($request->password);
        }


        $user->update($data);
        if($request->hasFile('avatar')){
            $img = $request->file('avatar');
            $filename = time(). '.' . $img->getClientOriginalExtension();
            //Image::configure(array('driver' => 'imagick'));
            Image::make($img)->save( public_path('/upload/users/'.$filename));
            $user->avatar = '/upload/users/'.$filename;
            $user->save();
        }
        return redirect(route('users.index'));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }


        $user->delete($id);

        return redirect(route('users.index'));


    }


    public function getUserGroups($id) {

            $usergroups = UserGroup::where("partner_id",$id)->pluck("group_name","id");


        if(!empty($usergroups) && count($usergroups) > 0)
            return response()->json(['success'=>true, 'data'=>$usergroups], 200);
        return response()->json(['success'=>false], 200);
    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }
    public function threads()
    {
        return auth()->user()->unreadMeessages()->limit(5)->get()->toArray();
    }
}
