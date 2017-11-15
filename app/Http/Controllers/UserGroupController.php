<?php

namespace App\Http\Controllers;

use App\PartnerType;
use App\User;
use App\UserGroup;
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
        if(Auth::user()->user_group_id == 1  ){

            $usergroups = UserGroup::where('id', '!=' ,1)->where('id', '!=' ,2)->get();

        }elseif(Auth::user()->user_group_id == 2  ) {

            $usergroups = UserGroup::where('partner_id',Auth::user()->partner_id)->get();

        }

        return view('usergroups.index')->with('usergroups' , $usergroups );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('usergroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $models = [
            \App\Doctor::$model,
            \App\Patient::$model,
            \App\HotelGuest::$model,
            \App\Nurse::$model,
            \App\Order::$model,
            \App\Product::$model,
            \App\Transaction::$model
        ] ;        $actions = ['view', 'add' ,'edit' ,'delete'];
        $data = array();
        foreach ($models as $model){
            $var = '';
            foreach ($actions as $action){
                if(isset($input[$model.$action])){
                    $var .='1';
                }else {
                    $var .= '0';
                }

            }
            $data[$model]= $var ;
        }
        //dd($data);


        $action = serialize($data);


        $data['group_name'] = $input['group_name'];
        $data['action'] = $action;
        $data['partner_id'] = ($request->has('partner_id') && Auth::user()->isAdmin()) ? $request->input('partner_id') : Auth::user()->partner_id ;

        $usergroups = UserGroup::create($data);

        return redirect(route('usergroups.index'));

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
        $usergroup = UserGroup::find($id);

        if(empty($usergroup)){
            return redirect(route('usergroups.index'));
        }

        return view('usergroups.show')->with('usergroup' , $usergroup );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $usergroup = UserGroup::find($id);

        $models = [
            \App\Doctor::$model,
            \App\Patient::$model,
            \App\HotelGuest::$model,
            \App\Nurse::$model,
            \App\Order::$model,
            \App\Product::$model,
            \App\Transaction::$model
        ] ;        $actions = ['view', 'add' ,'edit' ,'delete'];

        $data = unserialize($usergroup['action']);

        foreach ($data as $k => $v){
            $result = str_split($v);
            $i =0 ;
            foreach ($actions as $a){
                $dataa[$k.$a] = $result[$i];
                $i++;
            }
        }

        $dataa['group_name']= $usergroup['group_name'];
        $dataa['id']= $usergroup['id'];

        if(empty($usergroup)){
            return redirect(route('usergroups.index'));
        }

        return view('usergroups.edit')->with('usergroup' , $dataa );

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
        ] ;        $actions = ['view', 'add' ,'edit' ,'delete'];
        $data = array();
        foreach ($models as $model){
            $var = '';
            foreach ($actions as $action){
                if(isset($input[$model.$action])){
                    $var .='1';
                }else {
                    $var .= '0';
                }

            }
            $data[$model]= $var ;
        }


        $action = serialize($data);

        $data['group_name'] = $input['group_name'];
        $data['action'] = $action;
        $data['partner_id'] = Auth::user()->partner_id ;

        if(empty($usergroup)){
            return redirect(route('usergroups.index'));
        }

        $usergroup->update($data);

        return redirect(route('usergroups.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

         $usergroup = UserGroup::find($id);
         if(empty($usergroup)){
             return redirect(route('usergroups.index'));
         }


         $usergroup->delete($id);


        return redirect(route('usergroups.index'));


    }
}
