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
        if(Auth::user()->ableTo('view',Product::$model)) {

            if (Auth::user()->user_group_id == 1) {

                $products = Product::get();

            } elseif (Auth::user()->user_group_id == 2) {

                $products = Product::where('partner_id', Auth::user()->partner_id)->get();

            } else {

                $products = Product::where('user_id', Auth::user()->id)->get();
            }

            return view('products.index')->with('products', $products);
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
        if(Auth::user()->ableTo('add',Product::$model)) {

            return view('products.create');
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
        if(Auth::user()->ableTo('add',Product::$model)) {

            if (Auth::user()->isAdmin())
                $count = Product::where('name', $request->name)->where('partner_id', $request->partner_id)->count();
            else
                $count = Product::where('name', $request->name)->where('partner_id', Auth::user()->partner_id)->count();


            if ($count > 0) {
                $err = "The name has already been taken.";
                return view('products.create')->with("repeat", $err);
            }

            $request->validate([
                'name' => 'required|min:5|max:50',
                'image' => 'required|image|mimes:jpg,png|max:5000',
                'price' => 'required|numeric',
            ]);


            $input = $request->all();

            $destinationPath = './upload/';
            $file = $request->file('image');
            $input['image'] = $file->getClientOriginalName();


            $file->move($destinationPath, $file->getClientOriginalName());

            $input['partner_id'] = ($request->has('partner_id') && Auth::user()->isAdmin()) ? $request->input('partner_id') : Auth::user()->partner_id;

            $products = Product::create($input);

            return redirect(route('products.index'));
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
        if(Auth::user()->ableTo('view',Product::$model)) {

            $product = Product::find($id);

            if (empty($product)) {
                return redirect(route('products.index'));
            }

            return view('products.show')->with('product', $product);
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
        if (Auth::user()->ableTo('view', Product::$model)) {

            $product = Product::find($id);

            if (empty($product)) {
                return redirect(route('products.index'));
            }

            return view('products.edit')->with('product', $product);
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
        if(Auth::user()->ableTo('view',Product::$model)) {

            if (Auth::user()->isAdmin())
                $count = Product::where('id', '!=', $id)->where('name', $request->name)->where('partner_id', $request->partner_id)->count();
            else
                $count = Product::where('id', '!=', $id)->where('name', $request->name)->where('partner_id', Auth::user()->partner_id)->count();


            if ($count > 0) {
                $err = "The name has already been taken.";
                $data = array();
                $data['id'] = $id;
                if (Auth::user()->isAdmin())
                    $data['partner_id'] = $request->partner_id;
                else
                    $data['partner_id'] = Auth::user()->partner_id;
                return view('products.edit')->with('product', $data)->with('repeat', $err);
            }

            $request->validate([
                'name' => 'required|min:5|max:50',
                'image' => 'image|mimes:jpg,png|max:5000',
                'price' => 'required|numeric',
            ]);

            $product = Product::find($id);

            if (empty($product)) {
                return redirect(route('products.index'));
            }
            $input = $request->all();
            $destinationPath = './upload/';

            if (isset($request->image)) {
                $file = $request->file('image');
                $input['image'] = $file->getClientOriginalName();
                $file->move($destinationPath, $file->getClientOriginalName());

            }


            $input['partner_id'] = ($request->has('partner_id') && Auth::user()->isAdmin()) ? $request->input('partner_id') : Auth::user()->partner_id;

            if (!isset($request->image)) {
                $product->update(
                    array(
                        'name' => request('name'),
                        'price' => request('price'),
                        'email' => request('email'),
                        'partner_id'=>$input['partner_id']
                    )
                );
            } else {
                $product->update($input);
            }

            return redirect(route('products.index'));
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
        if (Auth::user()->ableTo('view', Product::$model)) {

            $product = Product::find($id);
            if (empty($product)) {
                return redirect(route('products.index'));
            }
            $product->delete($id);
            return redirect(route('products.index'));
        }else {
            return view('extra.404');
        }
    }
}
