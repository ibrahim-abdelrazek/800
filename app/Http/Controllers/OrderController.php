<?php

namespace App\Http\Controllers;

use App\Commission;
use App\Doctor;
use App\Patient;
use App\Product;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Notifier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;
use App\OrderStatus;
use Barryvdh\DomPDF\Facade as PDF;

class OrderController extends Controller
{


    public function index()
    {
        //
        if(Auth::user()->ableTo('view',Order::$model)) {

            if (Auth::user()->isAdmin() || Auth::user()->isCallCenter()) {

                $orders = Order::all();

            } else {

                $orders = Order::where('partner_id', Auth::user()->partner_id)->get();


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
                'prescription' => 'mimes:jpeg,png,jpg,gif,svg,pdf',
                'insurance_claim'=> 'mimes:jpeg,png,jpg,gif,svg,pdf',
                'notes' => 'nullable|string',
                'patient_id' => 'required|numeric',
                'doctor_id' => 'required|numeric',
                
                ]);
            if($request->has('products') && is_array($request->products) ){
                if(count($request->products) > 1 || (count($request->products) == 1 && $request->products[0] != '0'))
                $this->validate($request, [
                    'quantities'=> 'required|array',
                    'quantities.*' => 'numeric',
                    'copayments'=> 'required|array',
                    'copayments.*' => 'numeric'
                ]);
            }
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
                'status_id' =>  getConfig('order_default_status')]
                );
            $order['products'] = null;
            $order['copayments'] = null;
            $order['prices'] = null;
            $order['total'] = 0;
            $order['totaldiscount'] = 0;
            $prices = array();
            if($request->has('products') && is_array($request->products)){
                if(count($request->products) > 1 || (count($request->products) == 1 && $request->products[0] != '0')) {
                    for ($i = 0; $i < count($request->products); $i++) {
                        $price = Product::find($request->products[$i])->price;
                        $order['totaldiscount'] += ($request->copayments[$i] > 0)? $request->quantities[$i] * $price * ($request->copayments[$i] / 100) : $request->quantities[$i] * $price;
                        $order['total'] += $request->quantities[$i] * $price;
                        $prices[] = $price;
                    }
                    $order = array_merge($order, [
                        'products' => array_combine($request->products, $request->quantities),
                        'copayments' => array_combine($request->products, $request->copayments),
                        'prices' => array_combine($request->products, $prices)
                    ]);
                }
            }
            if(Order::create($order)){
                /* 
                *Notify Staff 
                * Administrators 1
                * partner 2
                * Call Center Supervisor 28
                * Call Center Agent 29
                */
                $users = User::where('user_group_id', 1)->orWhere('user_group_id', 28)->orWhere('user_group_id', 29)->orWhere('partner_id', Auth::user()->partner_id)->get();
                foreach($users as $user){
                    Notifier::create(['user_id'=>$user->id]);
                }
                 return redirect(route('orders.index'));
            }
               
                
            
               

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
                'quantities'=> 'array',
                'quantities.*' => 'numeric',
                'copayments'=> 'array',
                'copayments.*' => 'numeric',
                'status_id' => 'required'
            ]);


            $orderr = Order::find($id);

            if (empty($orderr)) {
                return redirect(route('orders.index'));
            }
             if($orderr->status_id == 0){
                $this->validate($request, [
                    'quantities'=> 'required|array',
                    'quantities.*' => 'numeric',
                    'copayments'=> 'required|array',
                    'copayments.*' => 'numeric',
                ]);
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


            if($request->has('products') && is_array($request->products)){
                if(count($request->products) > 1 || (count($request->products) == 1 && $request->products[0] != '0')) {
                    $order['products'] = $orderr->products;
                    $order['copayments'] = $orderr->copayments;
                    $order['prices'] = $orderr->prices;
                    $order['canceled'] = $orderr->canceled;
                    $order['total'] = $orderr->total;
                    $order['totaldiscount'] = $orderr->totaldiscount;
                    unset($order['quantities']);
                    $prices = array();

                    for ($i = 0; $i < count($request->products); $i++) {
                        $price = Product::find($request->products[$i])->price;

                        if(!isset($orderr->products[$request->products[$i]])){
                            $order['products'][$request->products[$i]] = $request->quantities[$i];
                            $order['copayments'][$request->products[$i]] = $request->copayments[$i];
                            $order['prices'][$request->products[$i]] = $price;
                            $order['total'] += $request->quantities[$i] * $price;
                            $order['totaldiscount'] += ($request->copayments[$i] > 0)? $request->quantities[$i] * $price * ($request->copayments[$i] / 100) : $request->quantities[$i] * $price;
                        }
                        $prices[] = $price;
                    }

                    foreach($orderr->products as $key => $value){
                        if(!in_array($key, $request->products)){
                            $price = Product::find($key)->price;
                            $order['canceled'][$key] = true;
                            $order['total'] -= $order['products'][$key] * $price;
                            $order['totaldiscount'] -= ($order['copayments'][$key]  > 0)? $order['products'][$key] * $price * ($order['copayments'][$key] / 100) : $order['products'][$key] * $price;
                        }
                    }
                }
            } 
         

            //dd($order);
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
            if($order->status_id == 0 && $request->status == 1 && empty($order->copayments) && empty($order->products))
                return response()->json(['success'=>false, 'message' => 'You Must add products first'], 200);

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

    // Don't Touch anything here PLS
    public function GetOrderTable(Request $request){
        $orderStatus = $request->orderstatus;
        if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
            $orders = Order::where('status_id', $orderStatus)->with('patient', 'doctor');
        else
            $orders = Order::where('status_id', $orderStatus)->where('partner_id', Auth::user()->partner_id)->with('patient', 'doctor');    
        $response['sEcho'] = $request->sEcho;
        $response['iTotalRecords'] = $orders->count();
        $response['iTotalDisplayRecords'] = $orders->count();
        if(!empty($request->sSearch)){
            if(Auth::user()->isAdmin() || Auth::user()->isCallCenter())
            $patients = Patient::where('first_name', 'LIKE', '%' . $request->sSearch . '%')->orWhere('last_name','like','%'. $request->sSearch . '%')->pluck('id');
            else
               $patients = Patient::where('partner_id', Auth::user()->partner_id)->where(function($query){
               $query->where('first_name', 'LIKE', '%' . $request->sSearch . '%')->orWhere('last_name','like','%'. $request->sSearch . '%');
           })->pluck('id'); 
            $orders = Order::whereIn('patient_id', $patients)->where('status_id', $request->orderstatus)->get(); 
            $response['iTotalRecords'] = $orders->count();
            $response['iTotalDisplayRecords'] = $orders->count();
            $response['aaData'] = $orders;  


        }else{
          $response['aaData'] = $orders->get();  
        }
        
        return response()->json($response, 200);
    }
    public function GetNewOrderItem(Request $request)
    {
        $order = Order::where('id', $request->ObjectId)->first();
        if(!empty($order)){
            if(Auth::user()->isAdmin() || Auth::user()->isCallCenter() || ($order->partner_id == Auth::user()->partner_id))
                return response()->json($order, 200);

            return response()->json(['success'=>false], 200);
    
        }
        return response()->json(['success'=>false], 200);
    }
    public function CheckNewOrder(Request $request)
    {
        // Get Notifier by id
        $notifiers = Notifier::where('user_id', Auth::user()->id)->where('read_at', NULL)->get();
        if($notifiers->count() > 0){
            //Update Read
            foreach($notifiers as $notifier){
                $notifier->read_at = date('Y-m-d H:i:s');
                $notifier->save();
            }
            return response()->json(['Message'=>  $notifier->count() . ' Order has been add', 'NoData'=>"false", 'success'=>"true"], 200);

        }
        return response()->json(['Message'=>'No New Data', 'NoData'=>"true", 'success'=>"true"], 200);
    }
    public function GetOrderDetailImage(Request $request)
    {
        $order =  Order::find($request->id);
        if(!empty($order))
        {
            if(Auth::user()->isAdmin() || Auth::user()->isCallCenter() || ($order->partner_id == Auth::user()->partner_id)){

            if(file_exists(public_path() . $order->prescription)){
              return response()->json([
                    'success'       =>true,
                    'OrderImageId' => $request->id,
                    'ImageBase64'   => 'data:image/jpeg;base64,'. base64_encode(file_get_contents(public_path() . $order->prescription))
            ], 200);  
            }
            return response()->json([
                    'success'       =>false,
                    'ImageBase64'   => null
            ], 200);
        }
        return response()->json([
                    'success'       =>false,
                    'ImageBase64'   => null
            ], 200);
        }
        return response()->json([
                    'success'       =>false,
                    'ImageBase64'   => null
            ], 200);
    }
    public function GetDetailItem(Request $request){
        if(!empty($request->ProductId) && !empty($request->ObjectId)){
            $order = Order::find($request->ObjectId);
            if(!empty($order)){
              if(Auth::user()->isAdmin() || Auth::user()->isCallCenter() || ($order->partner_id == Auth::user()->partner_id) || Auth::user()->ableTo('view',Order::$model)){
                 $product = Product::find($request->ProductId);
                 $response['ImageUrl'] = $product->ImageUrl;
                 $response['Product'] = $product->name;
                 $response['Quantity'] = $order->products[$product->id];
                 $response['PricePerItem'] = $product->price;
                 $response['Price'] = $order->products[$product->id] * $product->price;
                 $response['Discount'] = $order->products[$product->id] * $product->price * $order->copayments[$product->id] /100;
                 $response['IsCanceled'] = !empty($order->canceled) && array_key_exists($product->id, $order->canceled) ? true : false;
                 return response()->json($response, 200);
              }  
            }
            
        } 
    }
    public function GetUserItemDetail(Request $request){
        if(!empty($request->endUserId)){
            $patient = Patient::find($request->endUserId);
            if(!empty($patient) && (Auth::user()->isAdmin() || Auth::user()->isCallCenter() || $patient->partner_id == Auth::user()->partner_id))
                return response()->json($patient, 200);
        }
    }
    public function InsertDetailItem(Request $request){
         if((Auth::user()->isAdmin() || Auth::user()->isCallCenter() || Auth::user()->isPartner()|| Auth::user()->ableTo('edit',Order::$model)) && !empty($request->ProductId) && !empty($request->id) && !empty($request->Quantity)){
            $order = Order::where('id', $request->id)->first();
        //var_dump($order);//die();
            if(!empty($order)){
                if($request->insureRate == -1) 
                $request->insureRate = 0;
                $product = Product::where('id', $request->ProductId)->first();
                if(!empty($order->products)){
                    if(!empty($order->products[$request->ProductId])){
                        return response()->json(['success'=>false, 'message'=>"Can't add product twice"], 200);
                    }else{
                        $order->products = $order->products + [$request->ProductId=>$request->Quantity];
                        $order->copayments = $order->copayments + [$request->ProductId=>$request->insureRate];
                        $order->prices = $order->prices + [$request->ProductId=>$product->price];
                    }
                }else{
                    $order->products = [$request->ProductId=>$request->Quantity];
                    $order->copayments = [$request->ProductId=>$request->insureRate];
                }
                $normalPrice = $order->total + ($product->price * $request->Quantity);
                if($request->insureRate > 0){
                    $total = $order->totaldiscount + ($product->price * $request->Quantity * ( $request->insureRate / 100));
                }else{
                    $total = $order->totaldiscount + ($product->price * $request->Quantity);
                }
                $totalDiscount = $normalPrice - $total;

                $order->total = $normalPrice;
                $order->totaldiscount = $total;
            
                if($order->save())
                    return response()->json(['success'=>true, 'message'=>'product has been added', 'Total'=>$total, 'NormalPriceTotal'=>$normalPrice, 'DiscountTotal'=>$totalDiscount, 'Orders'=>$order->Orders], 200);
                return response()->json(['success'=>false, 'message'=>'failed to save order'], 200);    
            }
            return response()->json(['success'=>false, 'message'=>'order not found'], 200);
        }
        return response()->json(['success'=>false, 'message'=>'not authorized'], 200);
    }
    public function CancelDetailItem(Request $request){
        if((Auth::user()->isAdmin() || Auth::user()->isCallCenter() || Auth::user()->isPartner()|| Auth::user()->ableTo('edit',Order::$model))  && !empty($request->ProductId) && !empty($request->ObjectId) && !empty($request->IsCanceled) ){
            $order = Order::where('id', $request->ObjectId)->first();
            if(!empty($order)){
                
                if(!empty($order->canceled) && !array_key_exists($request->ProductId, $order->canceled))
                    $order->canceled = $order->canceled + [$request->ProductId=>true];
                else
                    $order->canceled = [$request->ProductId=>true];

                $normalPrice = $order->total - ($order->prices[$request->ProductId] * $order->products[$request->ProductId] );
                if($order->copayments[$request->ProductId] > 0){
                    $total = $order->totaldiscount - ($order->prices[$request->ProductId] * $order->products[$request->ProductId] * ($order->copayments[$request->ProductId] / 100));
                }else{
                    $total = $order->totaldiscount - ($order->prices[$request->ProductId] * $order->products[$request->ProductId]);
                }
                $totalDiscount = $normalPrice - $total;

                $order->total = $normalPrice;
                $order->totaldiscount = $total;

//                var_dump($normalPrice);
//                var_dump($totalDiscount);
//                var_dump($total);
//                var_dump($order);die();
                if($order->save())
                    return response()->json(['success'=>true, 'message'=>'product has been canceled', 'Total'=>round($total, 2), 'NormalPriceTotal'=>$normalPrice, 'DiscountTotal'=>$totalDiscount, 'Orders'=>$order->Orders], 200);
            return response()->json(['success'=>false, 'message'=>'failed to save order'], 200);    
            }
            return response()->json(['success'=>false, 'message'=>'order not found'], 200);
        }
        return response()->json(['success'=>false, 'message'=>'not authorized'], 200);
    }
    public function PrintOrder(Request $request, $id){
         if( Auth::user()->isAdmin() || Auth::user()->isCallCenter() || Auth::user()->isPartner()|| Auth::user()->ableTo('view',Order::$model) ) {

            $order = Order::find($id);

            if (empty($order)) {
                return redirect(route('orders.index'));
            }

            return view('orders.print')->with('order', $order);
        }else{
            return view('extra.404');
        }
    }    
    public function UpdateOrderDetailImage(Request $request){
         if((Auth::user()->isAdmin() || Auth::user()->isCallCenter() || Auth::user()->isPartner()|| Auth::user()->ableTo('edit',Order::$model)) && !empty($request->id) && !empty($request->degree)) {

            $order = Order::find($request->id);

            if (empty($order)) {
                return response()->json(['success'=>false, 'message'=>'fInvalid Image Id'], 200);  
            }
            $prescription = $order->prescription;
            if(file_exists(public_path() . $prescription)){
                Image::make(public_path() . $prescription)->rotate(-$request->degree)->save(public_path() . $prescription);
                return response()->json(['success'=>true, 'message'=>'Image rotated successfully'], 200);  
            }
            return response()->json(['success'=>false, 'message'=>'Image not found'], 200);
        }else{
            return response()->json(['success'=>false, 'message'=>'Not Authorized'], 200);
        }
    }
    public function Commission()
    {
        if (Auth::user()->isAdmin()) {
            $doctors = Doctor::all();
        } elseif(Auth::user()->isPartner()){
            $doctors = Doctor::where('partner_id', Auth::user()->id)->get();
        }elseif(Auth::user()->user_group_id == 31 ){
            $doctors = Doctor::where('id', Auth::user()->id)->get();
        }elseif(Auth::user()->ableTo('view',Commission::$model)) {
            $doctors = Doctor::where('partner_id', Auth::user()->partner_id)->get();
        }else{
            return view('extra.404');
        }
        return view('orders.commission.index')->with('doctors', $doctors);
    }

    public function CommissionDetails(Request $request){
//        dd($request->all());
        if($request->ajax()){
            $orders = DB::table('orders')->select(DB::raw('SUM(totaldiscount) as `TOTAL`'), DB::raw("DATE_FORMAT(created_at, '%m/%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                ->where('doctor_id', $request->ID)
                ->where('status_id', 4)
                ->groupby('year','month')
                ->get();
            return json_encode($orders);
        }
        return false;
    }
}