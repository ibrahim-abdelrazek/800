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
        if(Auth::user()->isAdmin()) {


            $products = Product::get();

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
        if(Auth::user()->isAdmin()) {

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
        if(Auth::user()->isAdmin()) {
            $request->validate([
                'name' => 'required|regex:/^[\pL\s]+$/u|min:3|max:50|unique:products',
                'image' => 'required|image|mimes:jpg,png,jpeg',
                'price' => 'required|numeric',
            ]);

            $input = $request->all();

            $destinationPath = './upload/';
            $file = $request->file('image');
            $input['image'] = $file->getClientOriginalName();
            $input['image']     = rand(0, 10000000) . '_' . $input['image'];
            $file->move($destinationPath, $input['image']);

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
        if(Auth::user()->isAdmin()) {

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
        if(Auth::user()->isAdmin()) {

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
        if(Auth::user()->isAdmin()) {


            $request->validate([
                'name' => 'required|min:3|regex:/^[\pL\s]+$/u|max:50|unique:products,name,' . $id ,
                'image' => 'image|mimes:jpg,png',
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
                $input['image']     = rand(0, 10000000) . '_' . $input['image'];
                $file->move($destinationPath, $input['image']);

            }

            if (!isset($request->image)) {
                $product->update(
                    array(
                        'name' => request('name'),
                        'price' => request('price'),
                        'email' => request('email'),
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
        if(Auth::user()->isAdmin()) {

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