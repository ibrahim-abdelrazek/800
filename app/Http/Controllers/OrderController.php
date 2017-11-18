<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Patient;
use App\Product;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;


class OrderController extends Controller
{


    public function index()
    {
        //
        if(Auth::user()->ableTo('view',Order::$model)) {

            if (Auth::user()->isAdmin()) {

                $orders = Order::get();

            } elseif (Auth::user()->user_group_id == 2) {

                $orders = Order::where('partner_id', Auth::user()->partner_id)->get();

            } else {

                $orders = Order::where('user_id', Auth::user()->id)->get();
            }

            return view('orders.index')->with('orders', $orders);
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
        if(Auth::user()->ableTo('add',Order::$model)) {

            return view('orders.create');
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
        //
        if(Auth::user()->ableTo('add',Order::$model)) {

            $this->validate($request, [
                'prescription' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'notes' => 'string',
                'patient_id' => 'required|numeric',
                'doctor_id' => 'required|numeric'
                ]);

            $prescription = '';
            // upload image
            if($request->hasFile('prescription')){
                $avatar = $request->file('prescription');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($avatar)->save( public_path('/upload/orders/'.$filename));
                $prescription = '/upload/orders/'.$filename;
                // remove old image
            }
            if ($request->has('partner_id')) {
                $order = $request->all();
            }else {
                if (!Auth::user()->user_group_id == 2) {
                    $order = array_merge($request->all(), ['partner_id' => Auth::user()->id]);
                } else {
                    $order = array_merge($request->all(), ['partner_id' => Auth::user()->partner->id]);
                }
            }
            $order = array_merge($order, ['user_id' => Auth::user()->id,
                'prescription' => $prescription,
                'status_id' => getConfig('order_default_status'),
                'products'=>array_combine($request->products, $request->quantities)]);
            if(Order::create($order))
                return redirect(route('orders.index'));

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
        if(Auth::user()->ableTo('view',Order::$model)) {

            $order = Order::find($id);

            if (empty($order)) {
                return redirect(route('orders.index'));
            }

            return view('orders.show')->with('order', $order);
        }else{
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
        if(Auth::user()->ableTo('edit',Order::$model)) {

            $order = Order::find($id);

            if (empty($order)) {
                return redirect(route('orders.index'));
            }

            return view('orders.edit')->with('order', $order);

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
        if(Auth::user()->ableTo('edit',Order::$model)) {

            //|image|mimes:jpeg,png,jpg,gif,svg|max:2048
            $this->validate($request, [
                'prescription' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'notes' => 'string',
                'patient_id' => 'required|numeric',
                'doctor_id' => 'required|numeric'
            ]);


            $orderr = Order::find($id);

            if (empty($order)) {
                return redirect(route('orders.index'));
            }

            // upload image
            $prescription = '';
            // upload image
            $order = $request->all();
            if($request->hasFile('prescription')){
                $avatar = $request->file('prescription');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                Image::make($avatar)->save( public_path('/upload/orders/'.$filename));
                $prescription = '/upload/orders/'.$filename;
                // remove old image
                $order = array_merge($order, ['prescription' => $prescription]);
            }

            $orderr->update($order);

            return redirect(route('orders.index'));
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
        if(Auth::user()->ableTo('delete',Order::$model)) {

            $order = Order::find($id);
            if (empty($order)) {
                return redirect(route('orders.index'));
            }
            $order->delete($id);
            return redirect(route('orders.index'));
        }else {

            return view('extra.404');
        }
    }

    public function getAll($id) {

        $patient = Patient::select(DB::raw("CONCAT(first_name,' ', last_name) AS full_name, id"))->where("partner_id",$id)->pluck("full_name","id");
        $product= Product::where("partner_id",$id)->pluck("name","id");
        $doctor = Doctor::where("partner_id",$id)->pluck("name","id");
        $all = array();
        $all = array_merge($all , ['patient' => $patient]);
        $all = array_merge($all , ['product' => $product]);
        $all = array_merge($all , ['doctor' => $doctor]);

        return json_encode($all) ;

    }

}
