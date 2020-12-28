<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyCartController extends Controller
{

    protected $buyCartController;


    /**
     * CartController constructor.
     * @param BuyCartController $buyCartController
     */
    public function __construct(CartController $buyCartController)
    {

        $this->buyCartController = $buyCartController;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->get();
        if (isset($users)) {
            if (isset($users[0])) {


                $data = Cart::select('carts.id', 'carts.status', 'carts.created_at', 'carts.request_id', 'users.document',
                    'users.name', 'users.apellido', DB::raw('sum(products.sale_price) as total'))
                    ->join('cart_products', 'carts.id', '=', 'cart_products.cart_id')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->join('products', 'products.id', '=', 'cart_products.product_id')
                    ->where('carts.user_id', $users[0]->id)
                    ->groupBy('carts.id')
                    ->get();
            }
        }
        return view('carts_list', ["carts" => $data]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = DB::table('users')->get();
        if (isset($users)) {
            if (isset($users[0])) {

                $cart = new Cart();
                $cart->user_id = $users[0]->id;
                $cart->status = 'pendiente';
                $cart->save();


                $response = $this->loadRequestToCreateRequest($request, $users[0], $cart->id);

                if ($response->isSuccessful()) {
                    $amount = 0;

                    DB::Table('carts')->where('id', $cart->id)->update(
                        array(
                            'request_id' => $response->requestId()
                        )
                    );

                    foreach (session()->get('cart') as $key => $value) {
                        $amount += $value['price'] * $value['quantity'];
                        $cartDetails = new CartProduct();
                        $cartDetails->cart_id = $cart->id;
                        $cartDetails->product_id = $value["id"];
                        $cartDetails->quantity = $value["quantity"];
                        $cartDetails->save();
                    }
                    $this->buyCartController->empty(0);

                    return redirect($response->processUrl());
                }

            }

        }
    }


    /**
     * @param int $idProduct
     * @param int $quantity
     */
    public
    function loadRequestToCreateRequest(Request $requestInput, $user, $cardId)
    {
        $amount = 0;
        $url = 'http://127.0.0.1:8000/buyCart/' . $cardId;
        if (session()->get('cart') != null) {
            foreach (session()->get('cart') as $key => $value) {
                $amount += $value['price'] * $value['quantity'];
            }

            $reference = 'TEST_' . time();
            $request = [
                "locale" => config('locale'),
                "buyer" => [
                    "name" => $user->name,
                    "surname" => $user->apellido,
                    "email" => $user->email,
                    "documentType" => "CC",
                    "document" => $user->document,
                    "mobile" => "3006108300",
                ],
                "payment" => [
                    "reference" => $reference,
                    "description" => config('description'),
                    "amount" => [
                        "currency" => "COP",
                        "total" => $amount
                    ]
                ],
                "expiration" => date('c', strtotime('+5 minutes')),
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox",
                "returnUrl" => $url
            ];

            $placetopay = new PlacetoPay([
                'login' => config('placetopay.login'),
                'tranKey' => config('placetopay.trankey'),
                'url' => config('placetopay.url'),
                'type' => config('placetopay.type'),
                'rest' => [
                    'timeout' => 45, // (optional) 15 by default
                    'connect_timeout' => 30, // (optional) 5 by default
                ]
            ]);

        }
        return $placetopay->request($request);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $users = DB::table('users')->get();
        if (isset($users)) {
            if (isset($users[0])) {

                $data = Cart::select('carts.id', 'carts.request_id', 'carts.created_at', 'users.document', 'users.name',
                    'users.apellido', 'products.name', 'products.id', 'products.productimg', 'cart_products.quantity',
                    'products.sale_price')
                    ->join('cart_products', 'carts.id', '=', 'cart_products.cart_id')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->join('products', 'products.id', '=', 'cart_products.product_id')
                    ->where('carts.user_id', $users[0]->id)
                    ->where('carts.id', $id)
                    ->get();


                $requestId = 0;
                foreach ($data as $id => $details) {
                    $requestId = $details['request_id'];
                }

                $placetopay = new PlacetoPay([
                    'login' => config('placetopay.login'),
                    'tranKey' => config('placetopay.trankey'),
                    'url' => config('placetopay.url'),
                    'type' => config('placetopay.type'),
                    'rest' => [
                        'timeout' => 45, // (optional) 15 by default
                        'connect_timeout' => 30, // (optional) 5 by default
                    ]
                ]);

                $response = $placetopay->query($requestId);


                if ($response->status()->message() != 'La petición se encuentra activa') {
                    DB::Table('carts')->where('request_id', $details['request_id'])->update(
                        array(
                            'status' => $response->status()->message()
                        )
                    );
                }


                return view('get_my_cart_by_id', ['carts' => $data], ['status' => $response->status()], ['id' => $id]);
            }
        }


    }

}



