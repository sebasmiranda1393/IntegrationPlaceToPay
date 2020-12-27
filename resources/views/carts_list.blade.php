@extends('layout.app')
@section('content')
    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:10%" class="text-center" bgcolor="#00bfff">Fecha de la compra</th>
            <th style="width:10%" class="text-center" bgcolor="#00bfff">Id Compra</th>
            <th style="width:10%" class="text-center" bgcolor="#00bfff">Documento</th>
            <th style="width:10%" class="text-center" bgcolor="#00bfff">Nombre</th>
            <th style="width:10%" class="text-center" bgcolor="#00bfff">Valor</th>
            <th style="width:10%" class="text-center" bgcolor="#00bfff">Estado</th>
            <th style="width:5%" class="text-center" bgcolor="#00bfff">Detalle de la compra</th>


        </tr>
        </thead>
        <tbody>

        <?php $total = 0 ?>


        @for ($i = 0; $i < count($carts); $i++)


            <tr>
                <td class="text-center" data-th="Created_at">{{ $carts[$i]['created_at'] }}</td>
                <td class="text-center" data-th="Created_at">{{ $carts[$i]['request_id'] }}</td>
                <td class="text-center" data-th="Created_at">{{ $carts[$i]['document'] }}</td>
                <td class="text-center"><strong>{{ $carts[$i]['name']}} {{ $carts[$i]['apellido']}}</strong></td>
                <td class="text-center"><strong>Total ${{ $carts[$i]['total']}}</strong></td>
                <td class="text-center"><strong>{{ $carts[$i]['status']}}</strong></td>
                <td class="text-center">
                    <a href="{{ route('buyCart.show' ,$carts[$i]['id'] ) }}">
                        <i class="fas fa-eye  fa-3x"></i></a>
                </td>

            </tr>
        @endfor

        </tbody>
    </table>
    <div class="col-sm-12">
        <a href="{{ URL::route('productos.index') }}" class="btn btn-primary">inicio </a>
    </div>
@endsection
