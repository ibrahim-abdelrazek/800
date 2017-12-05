<?php

namespace App\Http\Controllers;

use App\Partner;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
class PartnersController extends Controller
{
    protected  $location ;

    public function __construct()
    {
        $this->location =['Dubai'];
        //['Abu Dhabi' , 'Dubai' , 'Sharjah' , 'Ajman' ,'Umm Al Quwain','Ras Al Khaimah' ,'Fujairah' ];
    }

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
                'first_name' => 'required|min:5|max:50|regex:/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/u',
                'last_name' => 'required|min:5|max:50|regex:/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/u',
                'location' => 'required|max:100',
                'logo' =>'image|mimes:jpeg,png,jpg,gif,svg',
                'phone' => 'required|string|max:10',
                'fax' => '',
                'partner_type_id' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@$#%^&*]).*$/|confirmed',
                'password_confirmation'=>'',
                'commission' => 'numeric|min:0|max:100'
                ],
                ['password.regex' => 'Your Password must contain at least 6 characters as (Uppercase and Lowercase characters and Numbers and Special characters). ',
                ]);

            $partner  = new Partner();
            $partner->first_name = $request->first_name;
            $partner->last_name = $request->last_name;
            $partner->location = $this->location[$request->location];
            $partner->partner_type_id = $request->partner_type_id;
            $partner->phone = str_replace('+', '', $request->full_number);
            $partner->email = $request->email;
            $partner->commission = $request->has('commission') ? $request->commission : 0;
            $partner->fax = $request->fax;
            if($request->hasFile('logo')){
                $logo = $request->file('logo');
                $filename = time(). '.' . $logo->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($logo)->save( public_path('/upload/partners/'.$filename));
                $partner->logo = '/upload/partners/'.$filename;
                // remove old image
            }
            $partner->save();

            $users = User::create([
                'first_name' => request('first_name'),
                'last_name' => request('last_name'),
                'email' => request('email'),
                'password' => Hash::make(request('password')),
                'user_group_id' => 2,
                'partner_id' => $partner->id,
                'avatar' => $partner->logo
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

            if (empty($partner)) {
                return redirect(route("partners.index"));
            }else{
                $partner->location = array_search($partner['location'],$this->location);
                $partner->phone = (!empty($partner->phone))? '+'.$partner->phone:$partner->phone;
            }
            return view('partners.edit')->with("partner", $partner);
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

            $userID = User::where('partner_id', $id)->where('user_group_id',2)->value('id');

            $request->validate([
                'first_name' => 'required|min:5|max:50|regex:/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/u',
                'last_name' => 'required|min:5|max:50|regex:/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/u','location' => 'required|max:100',
                'partner_type_id' => 'required',
                'email' => 'required|unique:users,email,' . $userID,
                'phone' => 'required|string|max:10',
                //'fax' => 'numeric'
            ]);


            if($request->hasFile('logo'))
                $request->validate(['logo' =>'image|mimes:jpeg,png,jpg,gif,svg',
                ]);
            if($request->has('password') && !empty($request->password ))
                $request->validate(['password' => 'min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed',
                    'password_confirmation'=>''
                ]);
            $partner = Partner::where('id', $id)->first();
            $request['location'] = $this->location[$request->location];

            $data = $request->all();
            if ($request->has('full_number')) {
                $data['phone'] = str_replace('+', '', $request->full_number);
            }

            $partner->update($data);

            if($request->hasFile('logo')){
                $logo = $request->file('logo');
                $filename = time(). '.' . $logo->getClientOriginalExtension();
                Image::make($logo)->save( public_path('/upload/partners/'.$filename));
                $partner->logo = '/upload/partners/'.$filename;
                $partner->save();
                $partner->user->update(['avatar'=>$partner->logo]);
                // remove old image
            }
            if (isset($request->password)) {
                User::where('id', $userID)->update(array(
                    'first_name' => request('first_name'),
                    'last_name' => request('last_name'),
                    'email' => request('email'),
                    'password' => Hash::make(request('password')),
                    'user_group_id' => 2,
                ));
            } else {
                User::where('id', $userID)->update(array(
                    'first_name' => request('first_name'),
                    'last_name' => request('last_name'),
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
