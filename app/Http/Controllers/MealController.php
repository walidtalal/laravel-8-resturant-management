<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;
use Nette\Utils\Image;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $meals = Meal::paginate(5);
        return view("meals.index", compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::latest()->get();
        return view("meals.create_meal", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        //
//        $request->validate([
//            'name'=>'string|required|min:3|max:40,',
//            'description'=>'string|required|min:3|max:500,',
//            'price'=>'numeric|required|',
//            'image'=>'required|mimes:png,jpg,jpeg,'
//        ]);
//
//        $image = $request->file("image");
//        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalName();
//        Image::make($image)->resize(300,300)->save('upload/Meals/'.$name_gen);
//
//        $save_url = 'upload/Meals/'. $name_gen;
//
//        Meal::create([
//           "category"=> $request->category,
//           "name"=> $request->name,
//           "description"=> $request->description,
//           "price"=> $request->price,
//           "image"=> $save_url,
//        ]);
//
//        return redirect()->route("meal.index")->with("message", 'تم إضافة الوجبة بنجاح');
//    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'string|required|min:3|max:40,',
            'description'=>'string|required|min:3|max:500,',
            'price'=>'numeric|required|',
            'image'=>'required|mimes:png,jpg,jpeg,'
        ]);

// Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Using time() and original name
            $image->move(public_path('uploads'), $imageName); // Save the image to the public/uploads directory
            $imagePath = 'uploads/' . $imageName; // Store the image path
        } else {
            $imagePath = ''; // Set a default value if no image is uploaded
        }



        Meal::create([
            "category"=> $request->category,
            "name"=> $request->name,
            "description"=> $request->description,
            "price"=> $request->price,
            'image' => $imagePath, // Save the image path in the database

        ]);

        $notification = array(
            'message_id' => 'تم إضافة الوجبة بنجاح',
            'alert-type' => 'info'
        );

//        return redirect()->route('meal.index')->with($notification);
//        return redirect()->back()->with("message", 'تم إضافة الوجبة بنجاح');
        return redirect()->back()->with($notification);

//        return redirect()->route("meal.index")->with("message", 'تم إضافة الوجبة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal, $id)
    {
        //
        $meal = Meal::findOrFail($id);
        return view("meals.meal_details",compact("meal"));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal, $id)
    {
        //
        $meal = Meal::findOrFail($id);
        $categories = Category::all();
        return view('meals.edit_meal', compact('meal','categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:40',
            'description' => 'required|string|min:3|max:500',
            'price' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
            'category' => 'required',
        ]);

        $meal = Meal::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $imagePath = 'uploads/' . $imageName;
        } else {
            $imagePath = $meal->image; // Keep the existing image if no new image is uploaded
        }

        // Update meal details
        $meal->update([
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath ?? $meal->image, // Use existing image path if $imagePath is null
        ]);

        $notification = [
            'message_id' => 'تم تعديل الوجبة بنجاح',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
