<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Groups extends Controller
{
    protected $messages = [
        'name.required' => 'Наименование обязательно к заполнению',
        'sluh.required' => 'Имя для url обязательно к заполнению',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('admin.catalog.groups_list', [
            'groups' => Group::orderBy('active', 'desc')
                ->orderBy('sort', 'asc')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data = [];
        $data['action'] = route('groups.store');
        $data['is_new'] = true;
        return view('admin.catalog.group_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
        );

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return Redirect::route('groups.create')
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $entry = Group::create([
                "name" => $request->get('name'),
                "slug" => Str::slug($request->get('name')),
                "sort" => $request->get('sort') ?: 999,
                "active" => !is_null($request->get('active')),
            ]);
            return Redirect::route('groups.edit', $entry->id);
        } catch (\Exception $e) {
            return Redirect::route('groups.create')
                ->withInput()
                ->withErrors(['update' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        var_dump("show");
        die();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id)
    {
        $entry = Group::find($id);
        if (!$entry) {
            return $this->index();
        }

        $data = $entry->toArray();
        $data['action'] = route('groups.update', $id);
        $data['is_new'] = false;
        return view('admin.catalog.group_form', $data);
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
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required',
            'slug' => 'required',
        );

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return Redirect::route('groups.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $entry = Group::find($id);
        if (!is_null($request->get('name'))
            && $entry->name != $request->get('name')) {
            $entry->slug = Str::slug($request->get('name'));
        } else {
            $entry->slug = $request->get('slug');
        }
        $entry->name = $request->get('name');
        $entry->sort = $request->get('sort') ?: 999;

        $entry->active = !is_null($request->get('active'));

        try {
            $entry->save();
            return Redirect::route('groups.edit', $id);
        } catch (\Exception $e) {
            return Redirect::route('groups.edit', $id)
                ->withInput()
                ->withErrors(['update' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        var_dump("destroy");
        die();
    }
}
