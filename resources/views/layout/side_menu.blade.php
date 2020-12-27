<div class="col-md-10">
    <div>
        <ul class="navbar-nav nav">
            <li class="nav-item nav-profile border-bottom centrar">
                <a href="#" class="nav-link flex-column">
                    <div class="row">
                        <div class="centrar" class="col-sm-1  col-md-4 nav-profile-image">
                            <img class="centrar" src="https://img.icons8.com/cute-clipart/64/000000/shop.png"/>
                        </div>
                    </div>
                </a>
            </li>
            <br>
            <br>
            <li class="nav-item bg-light" style="border-style: solid; border-radius:25px" >
                <a class="nav-link {{ Request::is('roles') ? 'btn-info' : '' }}" href="{{ route('carts.index') }}">
                    <i class="mdi mdi-compass-outline menu-icon"></i>
                    <span class="menu-title"> <h2 style="color: #000000"> <small> Carro de compras</small></h2></span>
                </a>
            </li>

            <br>
            <li class="nav-item bg-light" style="border-style: solid; border-radius:25px" >
                <a class="nav-link {{ Request::is('roles') ? 'btn-info' : '' }}" href="#">
                    <i class="mdi mdi-compass-outline menu-icon"></i>
                    <span class="menu-title"> <h2 style="color: #000000"> <small> Listar Productos</small></h2></span>
                </a>
            </li>
            <br>

            <li class="nav-item bg-light" style="border-style: solid; border-radius:25px" >
                <a class="nav-link {{ Request::is('roles') ? 'btn-info' : '' }}" href="{{ route('buyCart.index') }}">
                    <i class="mdi mdi-compass-outline menu-icon"></i>
                    <span class="menu-title"> <h2 style="color: #000000"> <small> Mis Compras</small></h2></span>
                </a>
            </li>
        </ul>
    </div>
</div>
