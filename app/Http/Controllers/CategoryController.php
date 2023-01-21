<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required'
        ]);
        Category::add($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     */
    public function show(string $slug)
    {
        $category = Category::findBySlug($slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     */
    public function edit(string $slug)
    {
        $category = Category::findBySlug($slug);
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
            'title' => 'required'
        ]);

        $category = Category::find($id);
        $category->edit($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     */
    public function destroy(string $slug)
    {
        Category::findBySlug($slug)->remove();
    }
}
