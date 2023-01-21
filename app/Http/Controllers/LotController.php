<?php

namespace App\Http\Controllers;

use App\Filters\LotFilter;
use App\Models\Category;
use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\LotFilter $request
     */
    public function index(LotFilter $request)
    {
        //filter by query-param /?categories=slug1,slug2
        $lots = Lot::filter($request)->get();
        $categories = Category::all();

    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id')->all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required'
        ]);

        $lot = Lot::add($request->all());
        $lot->setCategories($request->get('categories'));

    }


    public function edit($slug)
    {
        $lot = Lot::findBySlug($slug);
        $categories = Category::pluck('title', 'id')->all();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required'
        ]);

        $lot = Lot::find($id);
        $lot->edit($request->all());
        $lot->setCategories($request->get('categories'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        Lot::findBySlug($slug)->remove();
    }

    public function show($slug)
    {
        $lot = Lot::findBySlug($slug);
        $categories = $lot->getCategoriesTitles();

    }
}
