<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Product::create(['name' => 'Leche','description' => 'Leche entera',
            'sale_price' => 2300.0,'productimg' => "leche alqueria 1578438734894.png" ,'quantity' => 2,]);

        App\Product::create(['name' => 'Agua','description' => 'Agua',
            'sale_price' => 2300.0, 'productimg' => "aguacristal585755888.png",'quantity' => 2]);

        App\Product::create(['name' => 'azucar','description' => 'azucar blanca',
            'sale_price' => 1000.00,'productimg' => "azucar1596412419.jpg" ,'quantity' => 2]);

        App\Product::create(['name' => 'leche condensada','description' => 'leche condensada nestle',
            'sale_price' => 2300.0, 'productimg' => "leche condensada1596412477.jpeg",'quantity' => 2,]);

        App\Product::create(['name' => 'jabon liquido','description' => 'Jabon liquido palmolive',
            'sale_price' => 7300.0,'productimg' => "jabon liquido1596421475.png" ,'quantity' => 12,]);

        App\Product::create(['name' => 'panela','description' => 'Panela cuadrada',
            'sale_price' => 6300.0, 'productimg' => "panela1596421508.png",'quantity' => 22,]);

        App\Product::create(['name' => 'arroz','description' => 'arroz diana',
            'sale_price' => 9300.0,'productimg' => "arroz1596421550.png" ,'quantity' => 2]);

        App\Product::create(['name' => 'toalla higuienica','description' => 'toallas nosotras',
            'sale_price' => 23000.0, 'productimg' => "toalla higuienica1596421625.png",'quantity' => 2]);

        App\Product::create(['name' => 'frijol','description' => 'frijol rojo',
            'sale_price' => 7300.0,'productimg' => "frijol1596421649.png" ,'quantity' => 2]);

        App\Product::create(['name' => 'queso','description' => 'queso parmesano alpina',
            'sale_price' => 21300.0, 'productimg' => "quesoparmesanoalpina7484848.png",'quantity' => 2]);

    }
}
