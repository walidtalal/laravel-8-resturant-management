<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(3);
//        dd($categories);
        return view("category.CategoryPage", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'cat_name'=>'string|required|unique:categories|min:3|max:40,'
        ]);
        Category::insert([
            'cat_name'=> $request->cat_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('message', 'تم إضافة صنف جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
//        $categories = Category::paginate(3);
////        dd($categories);
//        return view("category.CategoryPage", compact("categories"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, $id)
    {
        //
        $request->validate([
            'cat_name'=>'string|required|unique:categories|min:3|max:40,'
        ]);
        $category = Category::findOrFail($id);
        $category->update([
            'cat_name'=> $request->cat_name,
        ]);
        return redirect()->route("cat.index")->with('message', 'تم تحديث الصنف');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $id)
    {
        //
       $category = Category::find($id);
        $category->delete();
        return redirect()->route('cat.index')->with('message', 'تم حذف صنف جديد');

    }
}
