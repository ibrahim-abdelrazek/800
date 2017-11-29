<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Patient;
use App\Product;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
<<<<<<< HEAD
use App\OrderStatus;
=======
use Barryvdh\DomPDF\Facade as PDF;
>>>>>>> 198c2e25e3255a0194262c8523f63de21408bb88

class OrderController extends Controller
{


    public function index()
    {
        //
        if(Auth::user()->ableTo('view',Order::$model)) {

            if (Auth::user()->isAdmin()) {

                $orders = Order::get();

            } else {

                $orders = Order::where('partner_id', Auth::user()->partner_id);

<<<<<<< HEAD
            } else {

                $orders = Order::where('user_id', Auth::user()->id);
=======
>>>>>>> 198c2e25e3255a0194262c8523f63de21408bb88
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
                'prescription' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
                'insurance_claim'=> 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
                'notes' => 'nullable|string',
                'patient_id' => 'required|numeric',
                'doctor_id' => 'required|numeric',
                'quantities'=> 'required|array',
                'quantities.*' => 'numeric'
                ]);

            $prescription = '';
            $insurance_claim='';
            // upload image
            if($request->hasFile('prescription')){
                $avatar = $request->file('prescription');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                if(strpos($request->file('prescription')->getMimeType(), 'image') !== false) {
                    Image::make($avatar)->save( public_path('/upload/orders/'.$filename));
                }else {
                    Input::file('prescription')->move(base_path().'/public/upload/orders/', $filename);
                }
                $prescription = '/upload/orders/'.$filename;
                // remove old image
            }
            if($request->hasFile('insurance_claim')){
                $avatar = $request->file('insurance_claim');
                $filename = time(). '1.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                if(strpos($request->file('insurance_claim')->getMimeType(), 'image') !== false) {
                    Image::make($avatar)->save( public_path('/upload/orders/'.$filename));
                }else {
                    Input::file('insurance_claim')->move(base_path().'/public/upload/orders/', $filename);
                }
                $insurance_claim = '/upload/orders/'.$filename;
                // remove old image
            }

            if ($request->has('partner_id')) {
                $order = $request->all();
            }else {

                $order = array_merge($request->all(), ['partner_id' => Auth::user()->partner->id]);
            }
            $order = array_merge($order, ['user_id' => Auth::user()->id,
                'prescription' => $prescription,
                'insurance_claim' => $insurance_claim,
                'products'=>array_combine($request->products, $request->quantities),
                'status_id' =>  getConfig('order_default_status')]
                );
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
                'prescription' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                'insurance_claim' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                'notes' => 'nullable|string',
                'patient_id' => 'required|numeric',
                'doctor_id' => 'required|numeric',
                'quantities'=> 'required|array',
                'quantities.*' => 'numeric',
                'status_id' => 'required'
            ]);


            $orderr = Order::find($id);

            if (empty($orderr)) {
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
                if(strpos($request->file('prescription')->getMimeType(), 'image') !== false) {
                    Image::make($avatar)->save( public_path('/upload/orders/'.$filename));
                }else {
                    Input::file('prescription')->move(base_path().'/public/upload/orders/', $filename);
                }
                $prescription = '/upload/orders/'.$filename;
                // remove old image
                $order = array_merge($order, ['prescription' => $prescription]);
            }
            if($request->hasFile('insurance_claim')){
                $avatar = $request->file('insurance_claim');
                $filename = time(). '.' . $avatar->getClientOriginalExtension();
                //Image::configure(array('driver' => 'imagick'));
                if(strpos($request->file('insurance_claim')->getMimeType(), 'image') !== false) {
                    Image::make($avatar)->save( public_path('/upload/orders/'.$filename));
                }else {
                    Input::file('insurance_claim')->move(base_path().'/public/upload/orders/', $filename);
                }
                $insurance_claim = '/upload/orders/'.$filename;
                // remove old image
                $order = array_merge($order, ['insurance_claim' => $insurance_claim]);
            }

            $order = array_merge($order, ['products'=>array_combine($request->products, $request->quantities)]);



            //dd($orderr);
            $orderr->update($order);

            return redirect(route('orders.index'));
        }else {
            return view('extra.404');
        }
    }
    public function updateStatus(Request $request)
    {
        if(Auth::user()->ableTo('edit',Order::$model)) {

            $this->validate($request, [
               'order' => 'required|numeric',
               'status' => 'required|numeric',
               'notes' => 'string'
            ]);


            $order = Order::find($request->order);

            if (empty($order)) {
                return response()->json(['success'=>false, 'message' => 'Order Not Found'], 200);
            }
            if($order->status->code == 'success')
                return response()->json(['success'=>false, 'message' => 'Can\'t update a delivered order'], 200);
            $order->status_id = $request->status;
            $order->save();
            
            $statusOrder = new OrderStatus;
            $statusOrder->order_id = $request->order;
            $statusOrder->status_id = $request->status;
            $statusOrder->notes = !empty($request->notes) ? $request->notes : '';
            $statusOrder->save();
           return response()->json(['success'=>true, 'message' => 'Order status has changed'], 200);
        }else {
            return response()->json(['success'=>false, 'message' => 'UnAuthorized!'], 503);
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
    public function download($id){

        $order = Order::find($id);

        $pdf = PDF::loadView('orders.print',['order'=>$order]);
        $filename = 'Order Id: #' .$order->id .'.pdf';

        return $pdf->download($filename);
    }

}
