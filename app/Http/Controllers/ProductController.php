<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        //
        if(Auth::user()->user_group_id == 1 ){

           $products = Product::get();

        }elseif (Auth::user()->user_group_id == 2 ) {

          $products = Product::where('partner_id',Auth::user()->partner_id)->get();

        } else{

        $products = Product::where('user_id',Auth::user()->id)->get();
        }

        return view('products.index')->with('products' , $products );
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.create');

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
        $request->validate([
        'name' => 'required|max:45',
        'image' => 'required',
        'price' => 'required',
        'partner_id'=>'required'
        ]);
        

        $input = $request->all();

         $destinationPath = './upload/';
         $file = $request->file('image');
         $input['image'] = $file->getClientOriginalName();
                //$input['image']  =  rand(0,10000000)  . '_' .$input['image'] ;
                /*$image = Product::make($file->getPathName());
                if( $file->width() > 1080 || $file->height() > 1350 ){
                    if($file->width() > 1080 && $file->height() < 1350)
                        $file->resize(1080, null);
                    elseif ($file->width() < 1080 && $file->height() > 1350)
                        $file->resize(null, 1350);
                    elseif($file->width() > $file->height()) {
                        $file->resize(1080, null);
                    }else {
                        $file->resize(null, 1350);
                    }
                }

               */
        $file->move($destinationPath,$file->getClientOriginalName());
        $products = Product::create($input);

         
        return redirect(route('products.index'));
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
        $product = Product::find($id);

        if(empty($product)){
            return redirect(route('products.index'));
        }

        return view('products.show')->with('product' , $product );
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
        $product = Product::find($id);

        if(empty($product)){
            return redirect(route('products.index'));
        }

        return view('products.edit')->with('product' , $product );
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
        $request->validate([
        'name' => 'required|max:45',
        'image' => 'required',
        'price' => 'required',
        'partner_id'=>'required'
        ]);

        $product = Product::find($id);

        if(empty($product)){
            return redirect(route('products.index'));
        }
       $input=$request->all();
        $destinationPath = './upload/';

         $file = $request->file('image');
         $input['image'] = $file->getClientOriginalName();
                //$input['image']  =  rand(0,10000000)  . '_' .$input['image'] ;
                /*$image = Product::make($file->getPathName());
                if( $file->width() > 1080 || $file->height() > 1350 ){
                    if($file->width() > 1080 && $file->height() < 1350)
                        $file->resize(1080, null);
                    elseif ($file->width() < 1080 && $file->height() > 1350)
                        $file->resize(null, 1350);
                    elseif($file->width() > $file->height()) {
                        $file->resize(1080, null);
                    }else {
                        $file->resize(null, 1350);
                    }
                }
*/
        $file->move($destinationPath,$file->getClientOriginalName());
        $product->update($input);
         

        return redirect(route('products.index'));
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
        $product =Product::find($id);
        if(empty($product)){
            return redirect(route('products.index'));
        }
        $product->delete($id);
        return redirect(route('products.index'));
    }
}
