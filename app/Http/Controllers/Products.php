<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use App\Models\ProductsInGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Products extends Controller
{
    protected $messages = [
        'name.required' => 'Наименование обязательно к заполнению',
        'sluh.required' => 'Имя для url обязательно к заполнению',
        'image.max' => 'Слишком большое фото',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
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
        return view('admin.catalog.products_list',
            ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data = [];
        $data['action'] = route('products.store');
        $data['groups'] = Group::where('active', 1)->get();
        $data['group'] = 0;
        $data['is_new'] = true;
        $data['root'] = env('ROOT');
        return view('admin.catalog.product_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return Redirect::route('products.create')
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->get('name'));
            $data['price'] = $data['price'] ?: 0;
            $data['active'] = !is_null($request->get('active'));

            $entry = Product::create($data);
            $this->update_product_in_group($entry->id, $request->get('group'));
        } catch (\Exception $e) {
            return Redirect::route('products.create')
                ->withInput()
                ->withErrors(['update' => $e->getMessage()]);
        }

        $error = "";

        if (!$this->update_image($entry, $request, $error)){
            return Redirect::route('products.edit', $entry->id)
                ->withInput()
                ->withErrors(['update' => $error]);
        }

        return Redirect::route('products.edit', $entry->id)->with(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $entry = Product::find($id);
        if (!$entry) {
            return $this->index();
        }

        $data = $entry->toArray();
        $data['action'] = route('products.update', $id);
        $data['groups'] = Group::where('active', 1)->get();
        $data['group'] = $this->get_product_group($id);
        $data['is_new'] = false;
        $data['root'] = env('ROOT');
        return view('admin.catalog.product_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return Redirect::route('products.create')
                ->withInput()
                ->withErrors($validator);
        }

        $entry = Product::find($id);
        $need_update_slug = $entry->name != $request->get('name');
        $entry->fill($request->all());

        if ($need_update_slug) {
            $entry->slug = Str::slug($request->get('name'));
        }

        $entry->active = !is_null($request->get('active'));

        try {
            $entry->save();
            $this->update_product_in_group($id, $request->get('group'));
        } catch (\Exception $e) {
            return Redirect::route('products.edit', $id)
                ->withInput()
                ->withErrors(['update' => $e->getMessage()]);
        }

        $error = "";

        if (!$this->update_image($entry, $request, $error)){
            return Redirect::route('products.edit', $entry->id)
                ->withInput()
                ->withErrors(['update' => $error]);
        }

        return Redirect::route('products.edit', $entry->id)->with(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function get_product_group($id)
    {
        $result = ProductsInGroups::where('product_id', $id)->first();
        if ($result) {
            return $result->group_id;
        }
        return 0;
    }

    private function update_product_in_group($product_id, $group_id)
    {
        ProductsInGroups::where('product_id', $product_id)->delete();
        $entry = new ProductsInGroups;
        $entry->product_id = $product_id;
        $entry->group_id = $group_id;
        $entry->save();
    }

    private function update_image(Product $entry, Request $request, &$error = "")
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);

        if ($validator->fails()){
            return true;
        }

        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $this->messages);

        if (!$validator->fails()){
            $request->image->move(public_path('images'), $request->image->getClientOriginalName());
            $entry->image = '/images/'.$request->image->getClientOriginalName();
            $entry->save();
            return true;
        }
        $error = $validator->messages();
        return false;
    }
}
