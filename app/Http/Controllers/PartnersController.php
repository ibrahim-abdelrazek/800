<?php

namespace App\Http\Controllers;

use App\Partner;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->ableTo('view', Partner::$model)) {
            $partners = Partner::all();

            return view("partners.index")->with('partners', $partners);
        }
        return view('extra.404');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->ableTo('add', Partner::$model)) {
            return view('partners.create');
        } else {
            return view('extra.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->ableTo('add', Partner::$model)) {
            //
            $request->validate([
                'name' => 'required',
                'location' => 'required',
                'partner_type_id' => 'required',
                'username' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            ],
                ['password.regex' => 'Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). ']);


            $partners = Partner::create([
                'name' => request('name'),
                'location' => request('location'),
                'partner_type_id' => request('partner_type_id')
            ]);

            $users = User::create([
                'name' => request('name'),
                'username' => request('username'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'user_group_id' => 2,
                'partner_id' => $partners->id
            ]);

            return redirect(route('partners.index'));
        }
        return view('extra.404');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->ableTo('view', Partner::$model)) {

            $partner = Partner::find($id);

            //$partnerUser = $partner->user; //to merge between 2 tables partner and users

            if (empty($partner)) {

                return redirect(route('partners.index'));
            }

            return view('partners.show')->with('partner', $partner);

        }
        return view('extra.404');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->ableTo('edit', Partner::$model)) {
            //

            $partner = Partner::where('id', $id)->first();

            $user = User::where('partner_id', $id)->first();
            $p = collect([
                'id' => $partner['id'],
                'name' => $partner['name'],
                'location' => $partner['location'],
                'partner_type' => $partner->partnerType->name,
                'username' => $user['username'],
                'email' => $user['email'],
                'uid' => $user['id']
            ]);

            if (empty($partner)) {

                return redirect(route("partners.index"));
            }

            return view('partners.edit')->with("partner", $p);
        }
        return view('extra.404');

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
        if (Auth::user()->ableTo('edit', Partner::$model)) {

            $userID =User::where('partner_id', $id)->where('user_group_id',2)->value('id');

            $request->validate([
                'name' => 'required',
                'location' => 'required',
                'partner_type_id' => 'required',
                'username' => 'required',
                'email' => 'required|unique:users,email,' . $userID
            ]);

            Partner::where('id', $id)->update(array(
                'name' => request('name'),
                'location' => request('location'),
                'partner_type_id' => request('partner_type_id')
            ));

            if (isset($request->password)) {
                User::where('id', $request->uid)->update(array(
                    'name' => request('name'),
                    'username' => request('username'),
                    'email' => request('email'),
                    'password' => bcrypt(request('password')),
                    'user_group_id' => 2,
                ));
            } else {
                User::where('id', $request->uid)->update(array(
                    'name' => request('name'),
                    'username' => request('username'),
                    'email' => request('email'),
                    'user_group_id' => 2,
                ));
            }


            return redirect(route("partners.index"));

        }
        return view('extra.404');

    }

    // to delete  all data of user

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->ableTo('delete', Partner::$model)) {
            //
        $partner = Partner::find($id);

        $user = User::where('partner_id', $id);

        if (empty($partner)) {

            return redirect(route("partners.index"));
        }


        $partner->delete($id);
        $user->delete($id);

        return redirect(route("partners.index"));
        }
        return view('extra.404');

    }

    protected function deleteModel($model, $id)
    {

        $ids = $model::where('user_id', $id)->select("id")->get();
        $del = $model::whereIn('id', $ids)->delete();

    }
}
