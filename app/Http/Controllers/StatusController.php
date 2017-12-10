<?php

namespace App\Http\Controllers;


use App\Status;
use App\GetUserGroup;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
class StatusController extends Controller
{

    protected  $code;

    public function __construct()
    {
        $this->code =['success', 'info','danger','warning'];
    }


    public function index()
    {
/*        if (Auth::user()->isAdmin()) {

            $statuses = Status::all();
            return view('settings.index')->with('status',$statuses );

        }else{
            return view('extra.404');
        }*/

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Auth::user()->isAdmin() || Auth::user()->isCallCenter()) {

            return view('status.create');
        }else{
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
        if ( Auth::user()->isAdmin() || Auth::user()->isCallCenter()) {
            $request->validate([
                'message' => 'required|min:3|max:50|unique:statuses',
                'code' => 'required',
            ]);

            Status::create([
                'message'=> request('message'),
                'code'=> $this->code[request('code')]
            ]);
            return redirect(route('settings.index'));


        }else{
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->isAdmin() || Auth::user()->isCallCenter()) {

            $status = Status::find($id);

            if (empty($status)) {
                return redirect(route('status.index'));
            }

            return view('status.edit')->with('status', $status);
        }else{
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
        if ( Auth::user()->isAdmin() || Auth::user()->isCallCenter()) {
            $request->validate([
                'message' => 'required|min:3|max:50|unique:statuses,message,' . $id,
                'code' => 'required',
            ]);

            $status = Status::find($id);

            $status->update([
                'message'=> request('message'),
                'code'=> $this->code[request('code')]
            ]);

            return redirect(route('settings.index'));

        }else{
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
        if (Auth::user()->isAdmin() || Auth::user()->isCallCenter()){
            $status = Status::find($id);

            if (empty($status)) {
                return redirect(route('settings.index'));
            }


            $status->delete($id);

            return redirect(route('settings.index'));
        }else{
            return view('extra.404');

        }

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
