<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $cart = session()->get('cart');
        $orders = Order::with('user')->orderBy('created_at', 'desc')->take(3)->where('user_id',auth()->user()->id)->get();
        return view('home',compact('products','cart','orders'));
    }

    public function adminHome()
    {
        $products = Product::count();
        $sales = Order::count();
        $today_sales = Order::whereDate('created_at',now())->count();
        $users = User::count();

        $daily_sales = Order::selectRaw('Year(created_at) year, Month(created_at) month ,Day(created_at) day, count(*) count ')
        ->groupBy('year','month','day')
        ->whereYear('created_at',date('Y'))
        ->whereMonth('created_at', date('m'))
        ->whereDay('created_at',date('d'))
        ->orderBy('day','asc')->get();

        $monthly_sales = Order::selectRaw('Year(created_at) year, Month(created_at) month, count(*) count ')
        ->groupBy('year','month')
        ->whereYear('created_at', date('Y'))
        ->whereMonth('created_at', date('m'))
        ->orderBy('month','asc')->get();

        return view('admin.home',compact('products','sales','today_sales','users','daily_sales','monthly_sales'));

        // return $monthly_sales;
    }

    public function changePass(Request $request)
    {
        $user = User::find($request->user_id);
        if(Hash::check($request->current_password, $user->password) || $request->n_pass === $request->cn_pass)
        {
            $user->password = Hash::make($request->n_pass);
            $user->save();
            return redirect()->route('login');
            // return "ok";
        }
        return back()->withErrors(['current_password' => 'The provided current password is incorrect.']);
    }
}
