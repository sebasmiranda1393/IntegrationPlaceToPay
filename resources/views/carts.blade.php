@extends('layout.app')
@section('content')

    <body style="background-color:#636060;">

    </body>
    <div class="card-header" style="background-color:#9C9998; text-align: center;">MI CARRO DE COMPRAS
    </div>

    <form action="{{ route('buyCart.store') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        <table id="cart" class="table table-bordered table-dark">
            <thead>
            <tr>
                <th style="width:45%" class="text-center" >Producto</th>
                <th style="width:10%" >Precio</th>
                <th style="width:7%" >cantidad</th>
                <th style="width:12%" class="text-center" >Subtotal</th>
                <th style="width:28%" ></th>
            </tr>
            </thead>
            <tbody>

            <?php $total = 0 ?>

            @if(session('cart'))
                @foreach(session('cart') as $id => $details)

                    <?php /** @var TYPE_NAME $details */
                    $total += $details['price'] * $details['quantity'] ?>

                    <tr>
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs">
                                    @if($details['photo']==null)
                                        <img src="{{ asset('image/imagen-no-disponible.png') }}"
                                             width="100" height="100" class="img-responsive"/>
                                    @else
                                        <img
                                            src="{{ asset('image/products/'.$details['photo'])}}"
                                            width="100" height="100" class="img-responsive"/>
                                    @endif
                                </div>

                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">${{ $details['price'] }}</td>


                        <td data-th="Quantity">
                            {{ $details['quantity'] }}
                        </td>

                        <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>

                        <div class="row">
                            <td class="actions" data-th="">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <a href="{{ route('carts.destroy',$details['id'])  }}" type="submit"
                                               class="btn btn-danger "> eliminar</a>
                                        </div>

                                        <div class="col-md-3">

                                            <a href="{{ URL::route('carts.increaseProduct',$details['id'])  }}"
                                               type="submit"
                                               class="btn btn-danger"> +</a>
                                        </div>

                                        <div class="col-md-3">

                                            <a href="{{ URL::route('carts.decreaseProduct',$details['id'])  }}"
                                               type="submit"
                                               class="btn btn-danger "> -</a>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </div>
                    </tr>
                @endforeach
            @endif

            </tbody>
            <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong>Total {{ $total }}</strong></td>
            </tr>
            </tfoot>
        </table>

        <td>
            <a href="{{ URL::route('productos.index') }}" class="btn btn-primary">
                continue comprando</a>


            <a href="{{ URL::route('carts.empty', 1) }}" class="btn btn-primary">
                vaciar carrito</a>

            <input type="submit" class=" btn btn-primary" value="pagar"/>


        </td>
    </form>
    @jquery
    @toastr_js
    @toastr_render



@endsection
