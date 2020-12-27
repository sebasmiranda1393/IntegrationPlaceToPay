@extends('layout.app')
@section('content')
        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width:30%" class="text-center">Producto</th>
                <th style="width:10%">Precio</th>
                <th style="width:3%">cantidad</th>
                <th style="width:12%" class="text-center">Subtotal</th>
                <th style="width:15%">fecha de la compra</th>
            </tr>
            </thead>
            <tbody>

            <?php $total = 0 ?>

            @foreach($carts as $id => $details)

                <?php /** @var TYPE_NAME $details */
                $total += $details['sale_price'] * $details['quantity'] ?>

                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs">
                                @if($details['productimg']==null)
                                    <img src="{{ asset('image/imagen-no-disponible.png') }}"
                                         width="100" height="100" class="img-responsive"/>
                                @else
                                    <img
                                        src="{{ asset('image/products/'.$details['productimg'])}}"
                                        width="100" height="100" class="img-responsive"/>
                                @endif
                            </div>

                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>

                    <td data-th="price">${{ $details['sale_price'] }}</td>
                    <td data-th="quantity">{{ $details['quantity'] }}</td>
                    <td data-th="Subtotal" class="text-center">${{ $details['sale_price'] * $details['quantity'] }}</td>
                    <td data-th="created_at">{{ $details['created_at'] }}</td>
                </tr>
            @endforeach

            </tbody>

            <tfoot>
            <tr class="visible-xs">
                <td data-th="created_at">{{ $status->message() }}</td>
                @if( $status->message() == "La petición se encuentra activa")

                    <td data-th="created_at">
                        <div class="col-sm-1">
                            <a
                                href="#">
                                <i class="fas fa-shopping-cart fa-3x"> </i> </a>
                        </div>
                    </td>
                @endif
                <td class="text-center"><strong>Total {{ $total }}</strong></td>
            </tr>
            </tfoot>
        </table>


        <div class="card">


            <div class=" col-sm-1">
                <a href="{{ route('buyCart.index') }}" class="btn btn-primary "> Atras </a>
            </div>


@endsection
