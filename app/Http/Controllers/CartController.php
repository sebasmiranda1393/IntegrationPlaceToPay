<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carts');
    }


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
    public function updateQuantityProductByDecrement(int $idProduct, int $quantity)
    {
        $quantity--;
        DB::Table('products')->where('id', $idProduct)->update(
            array(
                'quantity' => $quantity
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function empty(int $idProduct)
    {
        if ($idProduct == 0) {
            Session::pull('cart');
            toastr()->success('productos eliminados del carrito exitosamente');
            return redirect()->back();
        }
        $cart = session()->get('cart');
        if ($cart != null) {
            foreach ($cart as $key => $value) {
                $this->updateQuantityProductByDeleteProductOfCar($value["id"], $value['quantity']);
            }
            Session::pull('cart');
            toastr()->success('productos eliminados del carrito exitosamente');
        }
        return redirect()->back();
    }


    /**
     * @param int $idProduct
     * @param int $quantity
     */
    public function updateQuantityProductByDeleteProductOfCar(int $idProduct, int $quantity)
    {
        $product = Product::find($idProduct);
        $quantity = $quantity + $product->quantity;
        DB::Table('products')->where('id', $idProduct)->update(
            array(
                'quantity' => $quantity
            )
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {

        $cart = session()->get('cart');
        foreach ($cart as $key => $value) {
            if ($id == $value["id"]) {
                $this->updateQuantityProductByDeleteProductOfCar($id, $value['quantity']);
                Session::pull('cart.' . $key);
                break;
            }
        }

        toastr()->success('producto eliminado');
        return redirect()->back()->with('success');
    }

    /**
     * @param int $idProduct
     * @param int $quantity
     */
    public function increaseProduct(int $idProduct)
    {
        $this->commonOperations($idProduct, 'sum');
        return redirect()->back();
    }


    /**
     * @param int $idProduct
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decreaseProduct(int $idProduct)
    {
        $this->commonOperations($idProduct, 'res');
        return redirect()->back();

    }

    /**
     * @param int $idProduct
     * @param string $operations
     */
    public function commonOperations(int $idProduct, string $operations)
    {
        $product = Product::find($idProduct);
        $cart = session()->get('cart');
        if ($operations == 'sum') {
            if ($product->quantity == 0) {
                toastr()->warning('No hay mas existencias del producto');
            } else {
                $this->updateQuantityProductByDecrement($product->id, $product->quantity);
                $cart[$idProduct]['quantity']++;
                toastr()->success('producto agregado');
            }
        } else {
            if ($cart[$idProduct]['quantity'] == 1) {
                toastr()->warning('La cantidad del producto no puede llegar a cero. Elimine el producto!');
            } else {
                $this->updateQuantityProductByIncrement($product->id, $product->quantity);
                $cart[$idProduct]['quantity']--;
                toastr()->warning('has quitado una unidad de este producto');
            }
        }
        session()->put('cart', $cart);

    }

    /**
     * @param int $idProduct
     * @param int $quantity
     */
    public function updateQuantityProductByIncrement(int $idProduct, int $quantity)
    {
        $quantity++;
        DB::Table('products')->where('id', $idProduct)->update(
            array(
                'quantity' => $quantity
            )
        );
    }



}
