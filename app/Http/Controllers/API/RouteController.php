<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    // get all list from admin side
    public function list(){
        $users = User::get();
        $categories = Category::get();
        $products = Product::get();
        $orders = Order::get();
        $contacts = Contact::get();

        $adminSide = [
            'users' => $users,
            'categories' => $categories,
            'products' => $products,
            'orders' => $orders,
            'contacts' => $contacts
        ];
        return response()->json($adminSide, 200);
    }

    // get all category list
    public function categoryList(){
        $category = Category::orderBy('id','desc')->get();
        return response()->json($category, 200);
    }

    // create category
    public function categoryCreate(Request $request){
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $response = Category::create($data);
        return response()->json($response,200);
    }

    // create contact
    public function createContact(Request $request){
        $data = $this->getContactData($request);

        Contact::create($data);
        $contact = Contact::orderBy('created_at','desc')->get();
        return response()->json($contact, 200);
    }

    private function getContactData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
