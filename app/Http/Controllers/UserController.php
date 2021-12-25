<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function showAdminLogin(Request $request)
    {
        if(Auth::check() && Auth::user()->role === 1){
            return redirect('/admin/products/show');
        }
        return view('admin.login');
    }

    //
    public function AdminLogin(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email'=>'required|max:128',
                'password'=>'required|max:256',
            ]
        );
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $products = Product::all();
            return view('admin.index', compact('products'));
        }
        
    }

    public function showAllProducts(Request $request)
    {
        $products = Product::all();
        return view('admin.index', compact('products'));
    }
    
}
