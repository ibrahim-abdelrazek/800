<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\HotelGuest;
use App\Nurse;
use App\Partner;
use App\PartnerType;
use App\Patient;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class PartnerTypesController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partnerTypes = PartnerType::get();

        return view('partnertypes.index')->with('partnertypes' , $partnerTypes );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('partnertypes.create');
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
        $this->validate(request(), [
            'name' => [
                'required',
                'min:5',
                'max:50',
                'unique:partner_types',
                'regex:/^[\pL\s]+$/u'
                ]
        ],
            ['name.regex' => 'The name may only contain letters and space .']);

        $input = $request->all();

        $partnerTypes = PartnerType::create($input);

        return redirect(route('partnertypes.index'));

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
        $partnertype = PartnerType::find($id);

        if(empty($partnertype)){
            return redirect(route('partnertypes.index'));
        }

        return view('partnertypes.show')->with('partnertype' , $partnertype );

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

        $partnertype = PartnerType::find($id);

        if(empty($partnertype)){
            return redirect(route('partnertypes.index'));
        }

        return view('partnertypes.edit')->with('partnertype' , $partnertype );

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
        $partnertype = PartnerType::find($id);
        $request->validate([
            'name' => 'required|min:5|max:50|alpha_dash|unique:partner_types,name,'. $partnertype->name
        ],

            ['name.alpha_dash' => 'The name may only contain letters, numbers, and dashes( _ , - ) .']);



        if(empty($partnertype)){
            return redirect(route('partnertypes.index'));
        }

        $partnertype->update($request->all());

        return redirect(route('partnertypes.index'));

    }

    // to delete  all data of partner
    protected function deleteModel($model ,$id){

        $ids = $model::where('user_id',$id)->select("id")->get();
        $del = $model::whereIn('id', $ids)->delete();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //
        $partnertype = PartnerType::find($id);
        if(empty($partnertype)){
            return redirect(route('partnertypes.index'));
        }

        $partnertype->delete($id);



        return redirect(route('partnertypes.index'));


    }
}