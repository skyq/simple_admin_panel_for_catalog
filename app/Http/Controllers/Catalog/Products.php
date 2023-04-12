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
            ->orderBy('g.sort', 'asc')
            ->orderBy('p.sort', 'asc')
            ->select([
                'p.*',
                'g.name as group_name',
                'g.slug as group_slug',
                'g.id as group_id',
            ])
            ->where('p.active', 1)
            ->where('g.active', 1)
            ->get();
        $out = ['groups' => []];

        $cur_group = 0;
        $list = [];
        $group = [];
        foreach ($products as $product) {
            if ($cur_group != $product->group_id) {
                if (count($group) != 0) {
                    $list[] = $group;
                }
                $group = [
                    'group_id' => $product->group_id,
                    'group_slug' => $product->group_slug,
                    'group_name' => $product->group_name,
                    'products' => []
                ];
                $cur_group = $product->group_id;
            }
            $group['products'][] = $product;
        }
        if (count($group) != 0) {
            $list[] = $group;
        }

        return view('catalog.products_list',
            [
                'list' => $list
            ]);
    }
}
