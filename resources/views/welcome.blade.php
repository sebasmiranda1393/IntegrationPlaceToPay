@extends('layout.app')
@section('content')
    <div>
        <div class="row">
            <div class="col-md-2 bg-dark" >
                @include('layout.side_menu')
            </div>

            <div class="col-md-10"  style="margin: -87px 0px 0px 186px">

                <body style="background-color:#636060;">

                </body>
                <div class="col-md-12">
                    <div class="card-header" style="background-color:#9C9998; text-align: center;">LISTA DE PRODUCTOS
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>


                <div class="col-md-12">
                    <table class="table table-bordered table-dark">
                        <thead>
                        <tr>
                            <th style="text-align: center" scope="col">#</th>
                            <th style="text-align: center" scope="col">Nombre</th>
                            <th style="text-align: center" scope="col">Descripción</th>
                            <th style="text-align: center" scope="col">Valor</th>
                            <th style="text-align: center" scope="col">Cantidad</th>
                            <th style="text-align: center" scope="col">Imagen</th>
                            <th style="text-align: center" scope="col">Comprar</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($products as $product)

                            <tr>
                                <th scope="row" style="text-align: center">  {{ $product->id }} </th>
                                <td style="text-align: center">{{ $product->name }} </td>
                                <td style="text-align: center">{{ $product->description }} </td>
                                <td style="text-align: center">{{ $product->sale_price }} </td>
                                <td style="text-align: center">{{ $product->quantity }} </td>
                                <td style="text-align: center">
                                    @if($product->productimg==null)
                                        <img style="width:60px;height:60px;"
                                             src="{{ asset('image/imagen-no-disponible.png') }}">
                                    @else
                                        <img style="width:60px;height:60px;"
                                             src="{{ asset('image/products/'.$product->productimg)}}"> </a>
                                    @endif
                                </td>
                                <td style="text-align: center ">
                                    <a href="{{ route('carts.show', $product->id) }}">
                                        <i class="fas fa-shopping-cart fa-2x"> </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @jquery
    @toastr_js
    @toastr_render
@endsection
