<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\OrderTotal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CartItemCollection;

class CartController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cart = Cart::create([
            'id' => md5(uniqid(rand(), true)),
            'key' => md5(uniqid(rand(), true)),
            'visitor_ip' => '192.168.1.1',
        ]);

        return response()->json([
            'message' => "Корзина создана",
            'cartToken' => $cart->id,
            'cartKey' => $cart->key,
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');

        if ($cart->key != $cartKey) {
            return response()->json([
                'message' => 'Ключ который вы предоставили не совпадает с ключом этой корзины.',
            ], 400);
        }

        return response()->json([
                'cart' => $cart->id,
                'items' => CartItemResource::collection($cart->items),
            ], 200);
    }

    public function addProducts(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        //Check if the CarKey is Valid
        if ($cart->key != $cartKey) {
            return response()->json([
                'message' => 'Ключ который вы предоставили не совпадает с ключом этой корзины',
            ], 400);
        }

        //Check if the proudct exist or return 404 not found.
        try { $Product = Product::findOrFail($productID);} catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Продукт, который вы пытаетесь добавить, не существует.',
            ], 404);
        }

        //check if the the same product is already in the Cart, if true update the quantity, if not create a new one.
        $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->first();
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->update(['quantity' => $quantity]);
        } else {
            CartItem::create(['cart_id' => $cart->getKey(), 'product_id' => $productID, 'quantity' => $quantity]);
        }

        return response()->json(['message' => 'Корзина была успешно обновлена с предоставленной информацией о товаре'], 200);
    }

    public function checkout(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'firstName' => 'required|string|min:4|max:30',
            'lastName' => 'required|string|min:4|max:30',
            'phone' => 'required|min:5|digits_between:7,18',
            'city' => 'required',
            'adress' => 'required',
            //'phone' => 'required|regex:\/(992)[0-9]{9}\/',
            // 'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            $name = $request->input('name');
            $phone = $request->input('phone');
            $adress = $request->input('adress');
            $email = $request->input('email');
            $note = $request->input('note');
            $totalPrice = (float) 0.0;
            $items = $cart->items;

            foreach ($items as $item) {
                $product = Product::find($item->product_id);
                $price = $product->price;
                $inStock = $product->quantity;
                if ($inStock >= $item->quantity) {

                    $totalPrice = $totalPrice + ($price * $item->quantity);

                    $product->quantity = $product->quantity - $item->quantity;
                    $product->save();
                } else {
                    return response()->json([
                        'message' => 'Количество товара, которое вы заказываете' . $item->name .
                        ' не доступно на складе, только ' . $inStock . ' шт. есть в наличии, пожалуйста, обновите свою корзину, чтобы продолжить',
                    ], 400);
                }
            }

            $deliveryCost = Setting::where('key', 'delivery_cost')->first();

            $order = Order::create([
                'total_price' => $totalPrice,
                'delivery_cost' => $deliveryCost->value,
                'note' => $note ? $note : null,
                'current_status' => 1,
                'customer_name' => $name,
                'customer_email' => $email,
                'customer_phone_number' => $phone,
                'customer_address' => $adress,
            ]);

            OrderTotal::create(
                [
                'order_id' => $order->id,
                'code' => 'sub_total',
                'title' => "Итого",
                'value' => $deliveryCost->value,
                'sort_order' => 1
                ],
                [
                    'order_id' => $order->id,
                    'code' => 'shipping',
                    'title' => "Сумма доставки",
                    'value' => $deliveryCost->value,
                    'sort_order' => 2
                ],
                [
                    'order_id' => $order->id,
                    'code' => 'total',
                    'title' => "Общая сумма",
                    'value' => $totalPrice,
                    'sort_order' => 3
                ]
            );

            foreach ($cart->items as $item) {
                $product = Product::find($item->product_id);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'total' => $product->price * $item->quantity,
                    'quantity' => $item->quantity
                ]);
            }

            $cart->delete();

            return response()->json([
                'message' => 'ваш заказ был успешно принять, спасибо!',
                'orderID' => $order->getKey(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Ключ который вы предоставили не совпадает с ключом этой корзины.',
            ], 400);
        }
    }

    public function destroy(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');

        if ($cart->key != $cartKey) {
            return response()->json([
                'message' => 'Ключ который вы предоставили не совпадает с ключом этой корзины.',
            ], 400);
        }

        $cart->delete();

        return response()->json(null, 204);
    }

}
