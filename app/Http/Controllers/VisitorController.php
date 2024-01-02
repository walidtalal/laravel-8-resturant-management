<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $categories = Category::get();
//        $meals = Meal::get();

        if(!$request->category) {
            $selected_cat = "الصفحة الرئيسية";
            $meals = Meal::get();
//            $meals = Meal::paginate(6);
            return view('visitorPage' , compact("categories",'meals','selected_cat'));
//            return view("visitorPage", compact('categories','meals'));

        } else {
            $selected_cat = $request->category;
//            $meals = Meal::where('category',$request->category)->paginate(6);
            $meals = Meal::where('category',$request->category)->get();
            return view('visitorPage' , compact("categories",'meals',"selected_cat"));
        }

//        return view("visitorPage", compact('categories','meals'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
