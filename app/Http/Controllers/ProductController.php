<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;
use Svg\Tag\Rect;

class ProductController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function categoryAdd(Request $request)
    {
        $cat = new Category;
        $cat->category = $request->category;
        $cat->save();

        return back();
    }

    public function categoryDelete($id)
    {
        $cat = Category::find($id);
        $cat->delete();
        return back();
    }

    public function product()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('admin.productAdd', compact('products', 'categories'));
    }

    public function categorySearch(Request $request)
    {
        $category = Category::where('category', 'LIKE', "%$request->data%")->get();
        return $category;
    }

    public function productAdd(Request $request)
    {
        if ($request->photo) {
            $p_name = uniqid() . "_" . $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $p_name);

            $product = new Product;
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->instock = $request->instock;
            $product->photo = $p_name;

            $product->save();

            return back();
        }
    }

    public function productSearch(Request $request)
    {
        $product = Product::find($request->product_id);

        return $product;
    }

    public function productEdit(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->price = $request->price;
        $product->instock = $request->instock;
        $product->save();
        return back();
    }

    public function productDelete($id)
    {
        $product = Product::find($id);
        $product->delete();

        return back();
    }

    // public function productSearch(Request $request)
    // {
    //     $products = Product::where('name', 'LIKE', "%$request->text%")->get();
    //     return $products;
    // }

    public function addToSes(Request $request)
    {
        $product = Product::find($request->product_id);

        $cart = session()->get('cart');
        $cart[$product->id] = [
            "name" => $product->name,
            "photo" => $product->photo,
            "category" => $product->category->category,
            "price" => $product->price,
            "instock" => $product->instock,
            "quantity" => $request->quantity,
        ];
        session()->put('cart', $cart);
        return back();
    }

    public function emptyCart()
    {
        session()->pull('cart');
        return back();
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart');
        unset($cart[$id]);

        session()->put('cart', $cart);

        return back();
    }

    public function qtySearch(Request $request)
    {
        $qty = Product::where('id', $request->product_id)->first();
        return $qty;
    }

    public function confirm(Request $request)
    {
        DB::transaction(function () {
            $carts = session()->get('cart');
            foreach ($carts as $key => $cart) {
                $product = Product::find($key);
                $update_instock = $product->instock - $cart['quantity'];
                $product->instock = $update_instock;
                $product->save();
            }
        });
        // $carts = session()->get('cart');
        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->order_items = json_encode(session()->get('cart'));
        $order->payment = $request->payment;
        $order->save();
        // $pdf = Pdf::loadView('voucher',$carts);
        // return $pdf->download(uniqid().'_voucher.pdf');
        session()->pull('cart');
        return back();
    }

    public function orderList()
    {
        $orders = Order::with('user')->get();
        return view('order',compact('orders'));
    }

    public function voucher($id)
    {
        $order = Order::find($id);
        // $carts = $order->order_items;
        $pdf = Pdf::loadView('voucher',compact('order'));
        return $pdf->download(uniqid().'_voucher.pdf');
    }

    public function productList()
    {
        $products = Product::with('category')->get();
        return view('product_list',compact('products'));
    }

    public function history()
    {
        $orders = Order::with('user')->orderBy('created_at','desc')->get();
        return view('history',compact('orders'));
    }

    public function todaySale()
    {
        $orders = Order::whereDate('created_at', today())->get();
        // $orders = Order::where('created_at', '>=', today())
        //        ->where('created_at', '<', today()->addDay())
        //        ->get();
        return view('admin.today',compact('orders'));
    }

    public function adminHistory()
    {
        $orders = Order::with('user')->orderBy('created_at','desc')->get();
        return view('admin.history',compact('orders'));
    }
}
