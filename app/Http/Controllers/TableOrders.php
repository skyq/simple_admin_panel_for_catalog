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
        $start = new \DateTime(now());

        $data = DB::table(with(new TableOrder())->getTable() . ' as o')
            ->leftJoin(with(new Product())->getTable() . ' as p', 'o.product_id', '=', 'p.id')
            ->orderBy('o.created_at', 'desc')
            ->select([
                'p.id',
                'p.name',
                'p.image',
                'p.price',
                'o.table',
                'o.updated_at',
            ])
            ->where('o.created_at', ">=", $start->format( 'Y-m-d 00:00:00' ))
            ->where('p.active', 1)
//            ->toSql();
            ->get();
//        return $data;
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
