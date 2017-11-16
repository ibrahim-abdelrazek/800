<?php

namespace App\Http\Controllers;

use App\PartnerType;
use App\User;
use App\UserGroup;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserGroupController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin() || Auth::user()->isPartner()) {
            if (Auth::user()->user_group_id == 1) {

                $usergroups = UserGroup::where('id', '!=', 1)->where('id', '!=', 2)->get();

            } elseif (Auth::user()->user_group_id == 2) {

                $usergroups = UserGroup::where('partner_id', Auth::user()->partner_id)->get();

            }

            return view('usergroups.index')->with('usergroups', $usergroups);
        }else {

            return view('extra.404');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Auth::user()->isAdmin() || Auth::user()->isPartner()) {

            return view('usergroups.create');
        }else {

            return view('extra.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()->isAdmin())
            $count = UserGroup::where('group_name', $request->group_name)->where('partner_id', $request->partner_id)->count();
        else
            $count = UserGroup::where('group_name', $request->group_name)->where('partner_id', Auth::user()->partner_id)->count();


        if($count >0 ) {
            $err = "The name has already been taken.";
            return view('usergroups.create')->with("repeat", $err);
        }


        if(Auth::user()->isAdmin() || Auth::user()->isPartner()) {

            $request->validate([
                'group_name' => 'required|min:5|max:50|alpha_dash'],
                ['name.alpha_dash' => 'The name may only contain letters, numbers, and dashes( _ , - ) .']
            );

            $input = $request->all();
            $models = [
                \App\Doctor::$model,
                \App\Patient::$model,
                \App\HotelGuest::$model,
                \App\Nurse::$model,
                \App\Order::$model,
                \App\Product::$model,
                \App\Transaction::$model
            ];
            $actions = ['view', 'add', 'edit', 'delete'];
            $data = array();

            $j = -1;
            foreach ($models as $model) {
                $j++;
                $var = '';
                foreach ($actions as $action) {
                    if (isset($input[$model . $action])) {
                        $var .= '1';
                    } else {
                        $var .= '0';
                    }

                }
                $data[$model] = $var;
            }

            $action = serialize($data);


            $data['group_name'] = $input['group_name'];
            $data['action'] = $action;
            $data['partner_id'] = ($request->has('partner_id') && Auth::user()->isAdmin()) ? $request->input('partner_id') : Auth::user()->partner_id;

            $usergroups = UserGroup::create($data);

            return redirect(route('usergroups.index'));

        }else {

            return view('extra.404');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        if(Auth::user()->isAdmin() || Auth::user()->isPartner()) {

            $usergroup = UserGroup::find($id);

            if (empty($usergroup)) {
                return redirect(route('usergroups.index'));
            }

            return view('usergroups.show')->with('usergroup', $usergroup);
        }else {

            return view('extra.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->isAdmin() || Auth::user()->isPartner()) {

            $usergroup = UserGroup::find($id);

            $models = [
                \App\Doctor::$model,
                \App\Patient::$model,
                \App\HotelGuest::$model,
                \App\Nurse::$model,
                \App\Order::$model,
                \App\Product::$model,
                \App\Transaction::$model
            ];
            $actions = ['view', 'add', 'edit', 'delete'];

            $data = unserialize($usergroup['action']);

            foreach ($data as $k => $v) {
                $result = str_split($v);
                $i = 0;
                foreach ($actions as $a) {
                    $dataa[$k . $a] = $result[$i];
                    $i++;
                }
            }

            $dataa['group_name'] = $usergroup['group_name'];
            $dataa['id'] = $usergroup['id'];
            $dataa['partner_id'] = $usergroup['partner_id'];

            if (empty($usergroup)) {
                return redirect(route('usergroups.index'));
            }

            return view('usergroups.edit')->with('usergroup', $dataa);
        }else {

            return view('extra.404');
        }
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
        //
        if(Auth::user()->isAdmin() || Auth::user()->isPartner()) {

            if(Auth::user()->isAdmin())
                $count = UserGroup::where('id','!=',$id)->where('group_name', $request->group_name)->where('partner_id', $request->partner_id)->count();
            else
                $count = UserGroup::where('id','!=',$id)->where('group_name', $request->group_name)->where('partner_id', Auth::user()->partner_id)->count();


            if($count >0 ){
                $err = "The name has already been taken.";
                $data = array();
                $data['id']= $id;
                if(Auth::user()->isAdmin())
                    $data['partner_id']=$request->partner_id ;
                else
                    $data['partner_id']= Auth::user()->partner_id ;
                return view('usergroups.edit')->with('usergroup',$data )->with('repeat',$err );
            }



            $request->validate([
                'group_name' => 'required|min:5|max:50|alpha_dash',
            ], ['name.alpha_dash' => 'The name may only contain letters, numbers, and dashes( _ , - ) .']);


            $usergroup = UserGroup::find($id);

            $input = $request->all();
            $models = [
                \App\Doctor::$model,
                \App\Patient::$model,
                \App\HotelGuest::$model,
                \App\Nurse::$model,
                \App\Order::$model,
                \App\Product::$model,
                \App\Transaction::$model
            ];
            $actions = ['view', 'add', 'edit', 'delete'];
            $data = array();
            foreach ($models as $model) {
                $var = '';
                foreach ($actions as $action) {
                    if (isset($input[$model . $action])) {
                        $var .= '1';
                    } else {
                        $var .= '0';
                    }

                }
                $data[$model] = $var;
            }


            $action = serialize($data);

            $data['group_name'] = $input['group_name'];
            $data['action'] = $action;
            $data['partner_id'] = ($request->has('partner_id') && Auth::user()->isAdmin()) ? $request->input('partner_id') : Auth::user()->partner_id;

            if (empty($usergroup)) {
                return redirect(route('usergroups.index'));
            }
            $usergroup->update($data);

            return redirect(route('usergroups.index'));
        }else {

            return view('extra.404');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin() || Auth::user()->isPartner()) {

            $usergroup = UserGroup::find($id);
            if (empty($usergroup)) {
                return redirect(route('usergroups.index'));
            }


            $usergroup->delete($id);


            return redirect(route('usergroups.index'));

        } else {

            return view('extra.404');
        }

    }
}