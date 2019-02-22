<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\CartDetail;
use App\Product;
use App\Bill;
use App\BillDetail;
use DB;

class CartsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cart::getCart();
        $items = Cart::getCart();
        return response()->json([
            'cart_id' => count($items) ? $items[0]['cart_id'] : null,
            'items' => $items
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        if (!$data['cart_id']) {
            $data['cart_id'] = Cart::insertGetId([
                'user_id' => \Auth::id()
            ]);
        }
        if ($data['is_update']) {
            if (!$data['quantity']) {
                CartDetail::where('cart_id', $data['cart_id'])
                            ->where('product_id', $data['product_id'])
                            ->delete();
            } else {
                CartDetail::where('cart_id', $data['cart_id'])
                            ->where('product_id', $data['product_id'])
                            ->update(['quantity' => $data['quantity']]);
            }
        } else {
            CartDetail::create([
                'cart_id' => $data['cart_id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
            ]);
        }

        Product::where('id', $data['product_id'])->update(['inStock' => $data['inStock']]);

        DB::commit();
        return $data['cart_id'];
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $billId = Bill::insertGetId([
            'user_id' => \Auth::id(),
            'date_order' => date('Y-m-d H:i:s'),
            'total' => $data['total']
        ]);
        $dataInsert = [];
        foreach($data['items'] as $item) {
            $product['bill_id'] = $billId;
            $product['product_id'] = $item['id'];
            $product['quantity'] = $item['quantity'];
            $product['price'] = $item['price'];
            $dataInsert[] = $product;break;
        }
        BillDetail::insert($dataInsert);
        Cart::where('id', $data['items'][0]['cart_id'])->update(['is_current' => 0]);
        DB::commit();
        return $billId;
    }
}
