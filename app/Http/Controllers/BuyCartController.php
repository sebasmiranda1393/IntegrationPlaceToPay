<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use Dnetix\Redirection\Message\RedirectRequest;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class BuyCartController extends Controller
{

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

                $response = $this->loadRequestToCreateRequest($request, $users[0]);

                if ($response->isSuccessful()) {

                    $cart = new Cart();
                    $cart->user_id = $users[0]->id;
                    $cart->request_id = $response->requestId();
                    $cart->status = 'pendiente';
                    $cart->save();
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
    function loadRequestToCreateRequest(Request $requestInput, $user)
    {
        $amount = 0;
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
                "expiration" => date('c', strtotime('+2 hour')),
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox",
                "returnUrl" => "http://127.0.0.1:8000/productos"
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
        return  $placetopay->request($request);

    }

}



