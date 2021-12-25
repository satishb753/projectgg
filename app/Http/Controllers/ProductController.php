<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::where('user_id', $request->user()->id)->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name'=>'required|max:128',
                'description'=>'required|max:256',
                'image'=>'required|max:10000|mimes:jpeg,jpg,png,gif,svg',
            ]
        );
        $user_id = Auth::id();
        if ($image = $request->file('image')) {
            $new_imageName  = time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path('image'), $new_imageName);
        }
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $new_imageName,
            'user_id' => $user_id,
        ]);
        return redirect()->route('products.index')->with('msg', 'Product is inserted Successfully');
    }

    public function edit($id)
    {
        $product = Product::findorfail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate(
            [
                'name'=>'required|max:128',
                'description'=>'required|max:256',
                'image'=>'max:10000|mimes:jpeg,jpg,png,gif,svg',
            ]
        );
        $input = $request->all();
        if ($image = $request->file('image')) {
            $new_imageName  = time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path('image'), $new_imageName);
            $input['image'] = "$new_imageName";
        } else {
            unset($input['image']);
        }

        $product->update($input);
        return redirect()->route('products.index')->with('msg', 'Product is Updated Successfully');
    }


    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('products.index')->with('msg', 'Data is Deleted');
    }
}
