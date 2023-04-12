<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductsInGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Products extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table(with(new Product)->getTable() . ' as p')
            ->leftJoin(with(new ProductsInGroups())->getTable() . ' as pg', 'pg.product_id', '=', 'p.id')
            ->leftJoin(with(new Group())->getTable() . ' as g', 'pg.group_id', '=', 'g.id')
            ->orderBy('active', 'desc')
            ->orderBy('sort', 'asc')
            ->select([
                'p.*',
                'g.name as group'
            ])
            ->get();
        return view('catalog.products_list',
            ['products' => $products]);
    }
}
