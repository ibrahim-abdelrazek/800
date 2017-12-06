<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
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


            $categories = Category::where("parent",0)->get();

            return view('category.index')->with('categories', $categories);

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

            return view('category.create');
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
                'name' => 'required|min:3|max:50|unique:category',
                'parent' => 'required',
            ]);

            $input = $request->all();


            Category::create($input);
            return redirect(route('category.index'));

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

            $category = Category::find($id);

            if (empty($category)) {
                return redirect(route('category.index'));
            }

            return view('category.edit')->with('category', $category);
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
                'name' => 'required|min:3|max:50|unique:category,name,'.$id,
                'parent' => 'required',
            ]);

            $category = Category::find($id);

            if (empty($category)) {
                return redirect(route('category.index'));
            }


            $input = $request->all();


            $category->update($input);
            return redirect(route('category.index'));

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

            $category = Category::find($id);
            if (empty($category)) {
                return redirect(route('category.index'));
            }
            $category->delete($id);
            return redirect(route('category.index'));
        }else {
            return view('extra.404');
        }
    }
}