<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
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
        $person->name = $doctor->name;
        $person->job_title = $doctor->specialty . ' doctor';
        $person->email = $doctor->contact_email;
        $person->phone = $doctor->contact_number;
        $person->photo = $doctor->photo;
        if (!empty($doctor))
            return view('extras.card')->with('person', $person);
    }

    public function index()
    {
        //
        if(Auth::user()->ableTo('view',Doctor::$model)) {

            if (Auth::user()->isAdmin()) {

                $doctors = Doctor::all();

            } elseif (Auth::user()->user_group_id == 2) {

                $doctors = Doctor::where('partner_id', Auth::user()->partner_id)->get();

            } else {

                $doctors = Doctor::where('user_id', Auth::user()->id)->get();
            }
            $specialities = Doctor::select('specialty')->pluck('specialty');
            return view('doctors.index')->with('doctors', $doctors)->with('specialites', array_unique($specialities->toArray()));
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
                'name' => 'required|string|max:100',
                'specialty' => 'required|string',
                'contact_email' => 'required|email|unique:doctors,contact_email',
                'contact_number' => 'required|string',

            ]);


            if ($request->has('partner_id')) {
                $doctor = $request->all();
            } else {
                if (Auth::user()->user_group_id == 2) {
                    $doctor = array_merge($request->all(), ['partner_id' => Auth::user()->partner_id]);
                } else {
                    $doctor = array_merge($request->all(), ['partner_id' => Auth::user()->partner_id]);
                    $doctor = array_merge($doctor, ['user_id' => Auth::user()->id]);
                }
            }

            if($request->hasFile('photo')){
                $avatar = $request->file('photo');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($avatar)->resize(300, 300)->save( public_path('/upload/doctors/'.$filename));
                $doctor['photo'] = '/upload/doctors/'.$filename;
            }

            if (Doctor::create($doctor))
            return redirect(route('doctors.index'));

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
            $specialities = Doctor::select('specialty')->pluck('specialty');
            if (empty($doctor)) {
                return redirect(route('doctors.index'));
            }

            return view('doctors.edit')->with('doctor', $doctor)->with('specialites', array_unique($specialities->toArray()));
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
                'name' => 'required|string|max:100',
                'specialty' => 'required|string',
                'contact_email' => 'required|email|unique:doctors,contact_email,'.$doc->id,
                'contact_number' => 'required|string',

            ]);



            if (empty($doc)) {
                return redirect(route('doctors.index'));
            }

            if ($request->has('partner_id')) {
                $doctor = $request->all();
            } else {
                if (Auth::user()->user_group_id == 2) {
                    $doctor = array_merge($request->all(), ['partner_id' => Auth::user()->partner_id]);
                } else {
                    $doctor = array_merge($request->all(), ['partner_id' => Auth::user()->partner_id]);
                    $doctor = array_merge($doctor, ['user_id' => Auth::user()->id]);
                }
            }
            if($request->hasFile('photo')){
                $avatar = $request->file('photo');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($avatar)->resize(300, 300)->save( public_path('/upload/doctors/'.$filename));
                $doctor['photo'] = '/upload/doctors/'.$filename;
                // remove old image
                unlink(asset($doc->photo));
            }

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

        $nurses = Nurse::where("partner_id",$id)->pluck("name","id");
        if(!empty($nurses) && count($nurses) > 0)
            return response()->json(['success'=>true, 'data'=>$nurses], 200);
        return response()->json(['success'=>false], 200);
    }
}

