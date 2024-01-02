<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(Auth()->user()->is_admin==1) {
        $orders = Order::orderBy('id','DESC')->get();
            return view('AdminPage', compact("orders"));

        } else {
            $categories = Category::all();

            if(!$request->category) {
                $selected_cat = "الصفحة الرئيسية";
                $meals = Meal::get();
//            $meals = Meal::paginate(6);
                return view('UserPage' , compact("categories",'meals','selected_cat'));

            } else {
                $selected_cat = $request->category;
//            $meals = Meal::where('category',$request->category)->paginate(6);
                $meals = Meal::where('category',$request->category)->get();
                return view('UserPage' , compact("categories",'meals',"selected_cat"));
            }
        }



//        return view('home');
    }

    function changeStatus(Request $request, $id)
    {
        $order = Order::find($id);
        Order::where("id", $id)->update(['status'=>$request->status]);
        return back();
    }
}
