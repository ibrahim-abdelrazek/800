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
        if(Auth::user()->isAdmin())
            $count = User::where('email', $request->email)->where('partner_id', $request->partner_id)->count();
        else
            $count = User::where('email', $request->email)->where('partner_id', Auth::user()->partner_id)->count();

        if($count >0 ) {
            $err = "The Email has already been taken.";
            return view('users.create')->with("repeat", $err);
        }

        $request->validate([
            'name' => 'required|min:5|max:50|regex:/^[\pL\s]+$/u',
            'username' => 'required|min:5|max:50|regex:/^\S*$/',
            'email' => 'required',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            'user_group_id' => 'required',
        ],
            ['password.regex' => 'Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). ',
                'username.regex' => 'Username not allowing space',
                'name.alpha_dash' => 'The name may only contain letters, numbers, and dashes( _ , - ) .'
            ]);

        if(Auth::user()->isAdmin())
            $request->validate(['partner_id'=> 'required']);


        if (!$request->has('partner_id'))
            $user = array_merge($request->all(), ['partner_id' => Auth::user()->id]);
        else $user = $request->all();


        if (User::create($user))
            return redirect(route('users.index'));

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
        //
        if(Auth::user()->isAdmin())
            $count = User::where('id','!=',$id)->where('email', $request->email)->where('partner_id', $request->partner_id)->count();
        else
            $count = User::where('id','!=',$id)->where('email', $request->email)->where('partner_id', Auth::user()->partner_id)->count();

        if($count >0 ){
            $err = "The Email has already been taken.";
            $data = array();
            $data['id']= $id;
            if(Auth::user()->isAdmin())
                $data['partner_id']=$request->partner_id ;
            else
                $data['partner_id']= Auth::user()->partner_id ;
            return view('users.edit')->with('user',$data )->with('repeat',$err );
        }

        $request->validate([
            'name' => 'required|min:5|max:50|regex:/^[\pL\s]+$/u',
            'username' => 'required|min:5|max:50|regex:/^\S*$/',
            'email' => 'required',
            'user_group_id' => 'required',
        ]);

        if(Auth::user()->isAdmin())
            $request->validate(['partner_id'=> 'required']);

        if(isset($request->password)){
            $request->validate([
                'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            ],
                ['password.regex' => 'Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). ']);
        }

        $user = User::find($id);

        if (empty($user)) {
            return redirect(route('users.index'));
        }
        if (!isset($request->password)) {
            $user->update(
                array(
                    'name' => request('name'),
                    'username' => request('username'),
                    'email' => request('email'),
                    'user_group_id' => request('user_group_id'),
                    'partner_id'=> request('partner_id')
                )
            );
        } else {
            $user->update($request->all());
        }


        return redirect(route('users.index'));

    }


    // to delete  all data of user
    protected function deleteModel($model, $id)
    {

        $ids = $model::where('user_id', $id)->select("id")->get();
        $del = $model::whereIn('id', $ids)->delete();

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

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }
    public function threads()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }
}
