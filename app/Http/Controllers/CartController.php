<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {

            abort(404);

        }

        $cart = session()->get('cart');
        if (!$cart) {
            if ($product->quantity > 0) {

                $cart = [
                    $id => [
                        "id" => $product->id,
                        "name" => $product->name,
                        "description" => $product->description,
                        "quantity" => 1,
                        "price" => $product->sale_price,
                        "photo" => $product->productimg
                    ]
                ];
                $this->updateQuantityProductByDecrement($id, $product->quantity);
                session()->put('cart', $cart);
                toastr()->success('producto agregado');
                return redirect()->back()->with('success');
            } else {
                toastr()->warning('producto agotado, no se puede agregar al carro');
                return redirect()->back()->with('success');
            }
        }

        if (isset($cart[$id])) {
            if ($product->quantity > 0) {
                $cart[$id]['quantity']++;
                $this->updateQuantityProductByDecrement($id, $product->quantity);
                session()->put('cart', $cart);
                toastr()->success('producto agregado');
                return redirect()->back()->with('success');
            } else {
                toastr()->warning('producto agotado, no se puede agregar al carro');
            }
        }

        if ($product->quantity > 0) {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "description" => $product->description,
                "quantity" => 1,
                "price" => $product->sale_price,
                "photo" => $product->productimg
            ];
              session()->put('cart', $cart);
              $this->updateQuantityProductByDecrement($id, $product->quantity);
              toastr()->success('producto agregado');
              return redirect()->back()->with('success');
        } else {
            toastr()->warning('producto agotado, no se puede agregar al carro');
        }
        return redirect()->back()->with('success');



}

/**
 * @param int $idProduct
 * @param int $quantity
 */
public
function updateQuantityProductByDecrement(int $idProduct, int $quantity)
{
    $quantity--;
    DB::Table('products')->where('id', $idProduct)->update(
        array(
            'quantity' => $quantity
        )
    );
}

}
