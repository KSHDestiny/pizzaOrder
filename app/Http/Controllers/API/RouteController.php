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

    // delete category
    public function categoryDelete(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(["status" => true,"message" => "delete success"], 200);
        };
        return response()->json(["status" => false,"message" => "There is no category..."], 400);
    }

    // delete contact
    public function deleteContact($id){
        $data = Contact::where('id',$id)->first();

        if(isset($data)){
            Contact::where('id',$id)->delete();
            return response()->json(["status" => true,"message" => "delete success", "deleteData" => $data], 200);
        };
        return response()->json(["status" => false,"message" => "There is no contact..."], 400);
    }

    // category details
    public function categoryDetails($id){
        $data = Category::where('id',$id)->first();

        if(isset($data)){
            return response()->json(["status" => true,"category" => $data], 200);
        };
        return response()->json(["status" => false,"message" => "There is no category..."], 400);
    }

    // category update
    public function categoryUpdate(Request $request){
        $categoryId = $request->category_id;

        $dbSource = Category::where('id',$categoryId)->first();

        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            Category::where('id',$categoryId)->update($data);
            $response = Category::where('id',$categoryId)->first();
            return response()->json(['status' => true, 'message' => 'category update success...' , 'category' => $response], 200);
        }
        return response()->json(['status' => false, 'message' => 'There is no category to update...'], 400);
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

    private function getCategoryData($request){
        return [
            'name' => $request->category_name,
            'updated_at' => Carbon::now()
        ];
    }
}
