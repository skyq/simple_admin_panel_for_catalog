<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\TableOrders as TableOrder;

class TableOrders extends Controller
{

    public function index(Request $request)
    {
        $data = DB::table(with(new TableOrder())->getTable() . ' as o')
            ->leftJoin(with(new Product())->getTable() . ' as p', 'o.product_id', '=', 'p.id')
            ->orderBy('o.updated_at', 'desc')
            ->select([
                'p.id',
                'p.name',
                'p.image',
                'p.price',
                'o.table',
                'o.updated_at',
            ])
            ->where('p.active', 1)
            ->get();
        return response()->json($data);
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = array(
            'table' => 'required|integer',
            'product_id' => 'required|integer',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(["error" => "yup"], 400);
        }

        $product = Product::first($request->all('product_id'));

        if (!$product){
            return response()->json(["error" => "yup"], 404);
        }

        TableOrder::create($request->all());
        return response()->json(["error" => ""], 200);
    }
}
