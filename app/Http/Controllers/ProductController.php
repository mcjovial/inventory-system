<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Supplier;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->with('category', 'supplier')->get();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3 | unique:products',
            'category_id' => 'required| integer',
            'stock' => 'required',
            'cost_price_pack' => 'required',
            'image' => 'image',
            'sell_price_bottle' => 'required',
            'bottles_per_pack' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('image');
        $slug =  Str::slug($request->input('name'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('product'))
            {
                Storage::disk('public')->makeDirectory('product');
            }
            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('public')->put('product/'.$imageName, $postImage);
        } else
        {
            $imageName = 'default.png';
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->stock = $request->input('stock');
        $product->launch_cartons = 12;
        $product->cost_price_pack = $request->input('cost_price_pack');
        $product->bottles_per_pack = $request->input('bottles_per_pack');
        $product->cost_price_bottle = $request->input('cost_price_pack') / $request->input('bottles_per_pack');
        $product->sell_price_bottle = $request->input('sell_price_bottle');
        $product->launch_price = $request->input('sell_price_bottle') * $request->input('bottles_per_pack');
        $product->image = $imageName;
        $product->save();

        Toastr::success('Product Successfully Created', 'Success!!!');
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        // dd($product);
        return view('admin.product.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3',
            'category_id' => 'required| integer',
            'stock' => 'required',
            'cost_price_pack' => 'required',
            'image' => 'image',
            'sell_price_bottle' => 'required',
            'bottles_per_pack' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('image');
        $slug =  Str::slug($request->input('name'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('product'))
            {
                Storage::disk('public')->makeDirectory('product');
            }

            // delete old photo
            if (Storage::disk('public')->exists('product/'. $product->image))
            {
                Storage::disk('public')->delete('product/'. $product->image);
            }

            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('public')->put('product/'.$imageName, $postImage);
        } else
        {
            $imageName = $product->image;
        }

        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->supplier_id = $request->input('supplier_id');
        $product->stock = $request->input('stock');
        $product->cost_price_pack = $request->input('cost_price_pack');
        $product->cost_price_bottle = $request->input('cost_price_pack') / $request->input('bottles_per_pack');

        $product->sell_price_bottle = $request->input('sell_price_bottle');
        $product->bottles_per_pack = $request->input('bottles_per_pack');
        $product->image = $imageName;
        $product->launch_price = $request->input('sell_price_bottle') * $request->input('bottles_per_pack');
        $product->save();

        Toastr::success('Product Successfully Updated', 'Success!!!');
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // delete old photo
        if (Storage::disk('public')->exists('product/'. $product->image))
        {
            Storage::disk('public')->delete('product/'. $product->image);
        }

        $product->delete();
        Toastr::success('Product Successfully Deleted', 'Success!!!');
        return redirect()->route('admin.product.index');
    }
}
