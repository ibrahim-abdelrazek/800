<?php

namespace App\Http\Controllers;

use App\Nighborhood;
use App\Patient;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon;
use DB;

class PatientController extends Controller
{

    public function getNeighbors($id){
        $neighbors = Nighborhood::where("city_id",$id)->pluck("neighborhood_name","id");
        if(!empty($neighbors) && count($neighbors) > 0)
            return response()->json(['success'=>true, 'data'=>$neighbors], 200);
        return response()->json(['success'=>false], 200);
    }
    public function index()
    {
        //
        if(Auth::user()->ableTo('view',Patient::$model)) {

            if (Auth::user()->isAdmin()) {

                $patients = Patient::all();

            } else{

                $patients = Patient::where('partner_id', Auth::user()->partner_id)->get();

            }

            return view('patients.index')->with('patients', $patients);
        }else{
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
        if(Auth::user()->ableTo('add',Patient::$model)) {

            return view('patients.create');
        }else{
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
        //
        if(Auth::user()->ableTo('add',Patient::$model)) {

            $request->validate([
                'first_name' => 'required|string|max:45|min:3',
                'last_name' => 'required|string|max:100|min:3',
                'date' => 'required',
                'gender' => 'required',
                'contact_number' => 'required|string|max:10',
                'email' => 'required|email|unique:patients,email',
                'insurance_file' => 'required|mimes:jpg,png,jpeg,pdf',
                'insurance_provider' => 'numeric',
                'card_number' => 'string',
//                'insurance_expiry' => 'required',
                'id_file' => 'required|mimes:jpg,png,jpeg,pdf',
                'id_number' => 'string',
//                'id_expiry' => 'required',
                'notes' => 'max:200|min:0',
                'city'=>'required|numeric',
                'area' => 'required|numeric',
                'street' => 'max:150',
                'type1' => '',
            ]);

            //create address
            $address =  $request->street ."," . $request->area ."," .$request->city  ;

            if($request->type1 == 'home' &&  $request->type2 == 'villa')
                $address = $request->villa_number ."," .$address;

            if($request->type1 == 'home' &&  $request->type2 == 'apartment')
                $address = $request->apartment_number . "," . $request->apartment_name ."," .$address ;

            if($request->type1 == 'office')
                $address = $request->office_number . "," .$request->building_name . "," . $request->company_name ."," . $address ;

            $request['city_id'] = $request->city;
            $request['nighborhood_id'] = $request->area;
            //validation of address
            $patient = $request->except(['villa_number' ,'apartment_name' ,'apartment_number','street','type1','type2','company_name' ,'building_name' ,'office_number']);

            $patient =  array_merge($patient , ['address' => $address]);

            $patient['date'] = Carbon::parse($request->date)->format('Y-m-d');
            $patient['insurance_expiry'] = Carbon::parse($request->insurance_expiry)->format('Y-m-d');
            $patient['id_expiry'] = Carbon::parse($request->id_expiry)->format('Y-m-d');

            if (!$request->has('partner_id')) {

                $patient = array_merge($patient, ['partner_id' => Auth::user()->partner_id]);

            }
            if($request->hasFile('id_file')){
                
                $avatar = $request->file('id_file');
                $filename = time(). '1.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));


                if(strpos($request->file('id_file')->getMimeType(), 'image') !== false) {
                    Image::make($avatar)->save(public_path('/upload/insurance/' . $filename));
                }else {
                    Input::file('id_file')->move(base_path().'/public/upload/insurance/', $filename);
                }
                $patient['id_file'] = '/upload/insurance/'.$filename;



            }
            if($request->hasFile('insurance_file')){
                $avatar = $request->file('insurance_file');
                $filename = time(). '1.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                if(strpos($request->file('insurance_file')->getMimeType(), 'image') !== false) {
                    Image::make($avatar)->save(public_path('/upload/insurance/' . $filename));
                }else {
                    Input::file('insurance_file')->move(base_path().'/public/upload/insurance/', $filename);
                }
                $patient['insurance_file'] = '/upload/insurance/'.$filename;
            }
            if ($request->has('full_number')) {
                $patient['contact_number'] = str_replace('+', '', $request->full_number);
            }
            unset($patient['full_number']);

            if(Patient::create($patient))
                return redirect(route('patients.index'));


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
        if(Auth::user()->ableTo('view',Patient::$model)) {

            $patient = Patient::find($id);

            if (empty($patient)) {
                return redirect(route('patients.index'));
            }
            $address = explode(',',$patient->address);

            $count = count($address) ;
            if($count == 4){
                $patient->villa_number = $address[0];
                $patient->street =$address[1];


            }elseif($count == 5) {
                $patient->apartment_number = $address[0];
                $patient->apartment_name = $address[1];
                $patient->street =$address[2];



            }else {
                $patient->office_number = $address[0];
                $patient->building_name = $address[1];
                $patient->company_name = $address[2];
                $patient->street =$address[3];


            }

            return view('patients.show')->with('patient', $patient);
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
        //
        if(Auth::user()->ableTo('edit',Patient::$model)) {

            $patient = Patient::find($id);

            if (empty($patient)) {
                return redirect(route('patients.index'));
            }else{
                $patient->contact_number = (!empty($patient->contact_number))? '+'.$patient->contact_number:$patient->contact_number;
            }
            $address = explode(',',$patient->address);

            $count = count($address) ;
            if($count == 4){
                $patient->villa_number = $address[0];
                $patient->street =$address[1];
                $patient->area = $patient->area->neighborhood_name;
                $patient->city = $patient->city->city_name;
                $patient->type1= 'home';
                $patient->type2 = 'villa';

            }elseif($count == 5) {
                $patient->apartment_number = $address[0];
                $patient->apartment_name = $address[1];
                $patient->street =$address[2];
                $patient->area = $patient->area->neighborhood_name;
                $patient->city = $patient->city->city_name;
                $patient->type1= 'home';
                $patient->type2 = 'apartment';

            }else {
                $patient->office_number = $address[0];
                $patient->building_name = $address[1];
                $patient->company_name = $address[2];
                $patient->area = $patient->area->neighborhood_name;
                $patient->city = $patient->city->city_name;
                $patient->city = $address[5];
                $patient->type1 = 'office';

            }

            // dd($patient);
            return view('patients.edit')->with('patient', $patient);
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
        if (Auth::user()->ableTo('edit', Patient::$model)) {
            $patientt = Patient::find($id);

            $fieldsArr = [
                'first_name' => 'required|string|max:45|min:3',
                'last_name' => 'required|string|max:100|min:3',
                'date' => 'required',
                'gender' => 'required',
                'contact_number' => 'required|string|max:10',
                'email' => 'required|email|unique:patients,email,'.$patientt->id,
                'insurance_provider' => 'numeric',
                'card_number' => 'string',
//                'insurance_expiry' => 'required',
                'id_number' => 'string',
//                'id_expiry' => 'required',
                'notes' => 'max:200|min:0',
                'city'=>'required|numeric',
                'area' => 'required|numeric',
                'street' => 'max:150',
                'type1' => '',
            ];
            if($request->hasFile('insurance_file')){
                $fieldsArr['insurance_file'] = 'required|mimes:jpg,png,jpeg,pdf';
            }
            if($request->hasFile('id_file')){
                $fieldsArr['id_file'] = 'required|mimes:jpg,png,jpeg,pdf';
            }

            $request->validate($fieldsArr);


            if (empty($patientt)) {
                return redirect(route('patients.index'));
            }
            //create address
            $address =  $request->street ."," . $request->area ."," .$request->city  ;

            if($request->type1 == 'home' &&  $request->type2 == 'villa')
                $address = $request->villa_number ."," .$address;

            if($request->type1 == 'home' &&  $request->type2 == 'apartment')
                $address = $request->apartment_number . "," . $request->apartment_name ."," .$address ;

            if($request->type1 == 'office')
                $address = $request->office_number . "," .$request->building_name . "," . $request->company_name ."," . $address ;


            //validation of address
            $patient = $request->except(['villa_number' ,'apartment_name' ,'apartment_number','street','type1','type2','company_name' ,'building_name' ,'office_number']);
            $request['city_id'] = $request->city;
            $request['nighborhood_id'] = $request->area;
            $patient['date'] = Carbon::parse($request->date)->format('Y-m-d');
            $patient['insurance_expiry'] = Carbon::parse($request->insurance_expiry)->format('Y-m-d');
            $patient['id_expiry'] = Carbon::parse($request->id_expiry)->format('Y-m-d');
            $patient =  array_merge($patient , ['address' => $address]);


            if (!$request->has('partner_id')) {
                $patient = array_merge($patient, ['partner_id' => Auth::user()->partner_id]);
            }

            if(isset($fieldsArr['insurance_file'])){
                $avatar = $request->file('insurance_file');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();

                if(strpos($request->file('insurance_file')->getMimeType(), 'image') !== false) {
                    //Image::configure(array('driver' => 'imagick'));
                    Image::make($avatar)->save(public_path('/upload/insurance/' . $filename));
                }else {
                    Input::file('id_file')->move(base_path().'/public/upload/insurance/', $filename);
                }
                $patient['insurance_file'] = '/upload/insurance/'.$filename;
            }
            if(isset($fieldsArr['id_file'])){
                $avatar = $request->file('id_file');
                $filename = time(). '1.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                if(strpos($request->file('id_file')->getMimeType(), 'image') !== false) {
                    Image::make($avatar)->save(public_path('/upload/insurance/' . $filename));
                }else {
                    Input::file('id_file')->move(base_path().'/public/upload/insurance/', $filename);
                }
                $patient['id_file'] = '/upload/insurance/'.$filename;
            }

            if ($request->has('full_number')) {
                $patient['contact_number'] = str_replace('+', '', $request->full_number);
            }
            unset($patient['full_number']);
            //dd($patient);
            $patientt->update($patient);

            return redirect(route('patients.index'));
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
        //
        if(Auth::user()->ableTo('delete',Patient::$model)) {

            $patient = Patient::find($id);
            if (empty($patient)) {
                return redirect(route('patients.index'));
            }
            $patient->delete($id);
            return redirect(route('patients.index'));
        }else {
            return view('extra.404');
        }

    }
    public function searchpatient(Request $request)
    {

        $partner = Partner::find($request->c);
        if(!empty($partner)){
            $patients = Patient::where('partner_id', $request->c)->where(function($query) use ($request){//select(DB::raw("id, CONCAT(first_name,' ', last_name, ' - ', contact_number) AS name"))->

                $query->where('first_name', 'LIKE', '%'.$request->input('q').'%')
                       ->orWhere('last_name', 'LIKE', '%'.$request->input('q').'%')
                       ->orWhere('contact_number', 'LIKE','%'.$request->input('q').'%');
            })->get();
            $response = [];
            foreach ($patients as $patient) {
                          $res['id'] = $patient->id;
                          $res['name'] = $patient->first_name . ' ' . $patient->last_name . ' ( +' . $patient->contact_number.' )';
                          $response[] = $res;
                       }           
           return response()->json($response, 200);
        }
        return response()->json(['success'=>false], 200);   
    }
}
