<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Nurse;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\OrderScope;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCard($id)
    {
        $doctor = Doctor::find($id);
        $person = new \stdClass();
        $person->name = $doctor->first_name . ' ' . $doctor->last_name;
        $person->job_title = $doctor->specialty . ' doctor';
        $person->email = $doctor->contact_email;
        $person->phone = '+' . $doctor->contact_number;
        $person->photo = $doctor->photo;
        $person->nurses = $doctor->nurses;
        if (!empty($doctor))
            return view('extras.card')->with('person', $person);
    }

    public function index()
    {
        //
        if(Auth::user()->ableTo('view',Doctor::$model)) {

            if (Auth::user()->isAdmin() || Auth::user()->isCallCenter()) {

                $doctors = Doctor::all();

            } else{

                $doctors = Doctor::where('partner_id', Auth::user()->partner_id)->get();

            }
            $specialities = ["Cardiology","Child Psychiatry","Dermatology-Venereology","Emergency Medicine","Endocrinology","Family Medicine","Gastroenterology","General Practice","General Surgery","Geriatrics","Infectious Disease","Internal Medicine","Neonatology","Nephrology","Neurology","Neurosurgery","Obstetrics and Gynaecology","Ophthalmology","Orthodontics","Orthopaedics","Other","Paediatrics","Pathology","Physiotherapy and Rehabilitation","Plastic Surgery","Psychiatry","Public Health","Pulmonology","Radiology","Sports Medicine","Urology","Vascular Medicine","Vascular Surgery"];
            return view('doctors.index')->with('doctors', $doctors)->with('specialites', array_unique($specialities));
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
        if (Auth::user()->ableTo('add', Doctor::$model))
            return view('doctors.create');
            
        else
            return view('extra.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if (Auth::user()->ableTo('add', Doctor::$model)) {
            $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'specialty' => 'required|string',
                'contact_email' => 'required|email|unique:doctors,contact_email',
                'contact_number' => 'required|string|max:10',
                'photo' => 'image|mimes:jpg,jpeg,png',
                'nurses' => 'required|array',
                'nurses.*' => 'numeric'

            ]);


            if ($request->has('partner_id')) {
                $doctor = $request->all();
            } else {
                
                    $doctor = array_merge($request->all(), ['partner_id' => Auth::user()->partner_id]);
                    
            }

            if($request->hasFile('photo')){
                $avatar = $request->file('photo');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($avatar)->resize(300, 300)->save( public_path('/upload/doctors/'.$filename));
                $doctor['photo'] = '/upload/doctors/'.$filename;
            }


           if ($request->has('full_number')) {
               $doctor['contact_number'] = str_replace('+', '', $request->full_number);
           }
           unset($doctor['full_number']);

            if ($doc = Doctor::create($doctor)){
                // Assign new nurses to doctor
                $nurses = $request->nurses;
                $doc->nurses()->attach(array_unique($nurses));
                return redirect(route('doctors.index'));
            }
            

        } else {
            return view('extra.404');
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
        if (Auth::user()->ableTo('view', Doctor::$model)) {

            $doctor = Doctor::find($id);

            if (empty($doctor)) {
                return redirect(route('doctors.index'));
            }

            return view('doctors.show')->with('doctor', $doctor);
        } else {
            return view('extra.404');
        }
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
        if (Auth::user()->ableTo('edit', Doctor::$model)) {

            $doctor = Doctor::find($id);
            if (empty($doctor)) {
                return redirect(route('doctors.index'));
            }else{
                $specialities = ["Cardiology","Child Psychiatry","Dermatology-Venereology","Emergency Medicine","Endocrinology","Family Medicine","Gastroenterology","General Practice","General Surgery","Geriatrics","Infectious Disease","Internal Medicine","Neonatology","Nephrology","Neurology","Neurosurgery","Obstetrics and Gynaecology","Ophthalmology","Orthodontics","Orthopaedics","Other","Paediatrics","Pathology","Physiotherapy and Rehabilitation","Plastic Surgery","Psychiatry","Public Health","Pulmonology","Radiology","Sports Medicine","Urology","Vascular Medicine","Vascular Surgery"];
                $doctor->contact_number = (!empty($doctor->contact_number))? '+'.$doctor->contact_number:$doctor->contact_number;
            }

            return view('doctors.edit')->with('doctor', $doctor)->with('specialites', array_unique($specialities));
        } else {
            return view('extra.404');
        }
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
        if (Auth::user()->ableTo('edit', Doctor::$model)) {
            $doc = Doctor::find($id);
            $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'specialty' => 'required|string',
                'contact_email' => 'required|email|unique:doctors,contact_email,'.$doc->id,
                'contact_number' => 'required|string|max:10',
                'photo' => 'image|mimes:jpg,jpeg,png'

            ]);



            if (empty($doc)) {
                return redirect(route('doctors.index'));
            }

            if ($request->has('partner_id')) {
                $doctor = $request->all();
            } else {
                     $doctor = array_merge($request->all(), ['partner_id' => Auth::user()->partner_id]);
                   
            }
            if($request->hasFile('photo')){
                $avatar = $request->file('photo');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($avatar)->resize(300, 300)->save( public_path('/upload/doctors/'.$filename));
                $doctor['photo'] = '/upload/doctors/'.$filename;
                // remove old image
                //unlink(asset($doc->photo));
            }
            $nurses = $request->nurses;
            $doc->nurses()->sync(array_unique($nurses));

            if ($request->has('full_number')) {
                $doctor['contact_number'] = str_replace('+', '', $request->full_number);
            }
            unset($doctor['full_number']);

            if ($doc->update($doctor))
                return redirect(route('doctors.index'));

        } else {
            return view('extra.404');
        }
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
        if (Auth::user()->ableTo('delete', Doctor::$model)) {

            $doctor = Doctor::find($id);
            if (empty($doctor)) {
                return redirect(route('doctors.index'));
            }

            $doctor->delete($id);

            return redirect(route('doctors.index'));

        } else {
            return view('extra.404');
        }
    }

    /**
     * Get JSON Array of Nurses related doctors
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getNurses($id) {
        $nurses = Nurse::select(DB::raw("CONCAT(first_name, ' ' , last_name) AS name , id"))->where('partner_id',$id)->pluck("name","id");
        if(!empty($nurses) && count($nurses) > 0)
            return response()->json(['success'=>true, 'data'=>$nurses], 200);
        return response()->json(['success'=>false], 200);
    }
    public function getPatients($id) {

        $patients = Patient::select(DB::raw("CONCAT(first_name,' ', last_name) AS full_name, id"))->where('partner_id', $id)->pluck('full_name','id');
        if(!empty($patients) && count($patients) > 0)
            return response()->json(['success'=>true, 'data'=>$patients], 200);
        return response()->json(['success'=>false], 200);
    }
    public function getDoctors($id) {

        $doctors = Doctor::select(DB::raw("CONCAT(first_name, ' ' , last_name) AS name , id"))->where('partner_id',$id)->pluck("name","id");
        if(!empty($doctors) && count($doctors) > 0)
            return response()->json(['success'=>true, 'data'=>$doctors], 200);
        return response()->json(['success'=>false], 200);
    }
}

