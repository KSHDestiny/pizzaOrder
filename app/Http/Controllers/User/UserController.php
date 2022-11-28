<?php

namespace App\Http\Controllers\User;

use Storage;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // user home page
    public function home(){
        $pizzas = Product::orderBy('created_at','desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizzas','categories','cart','history'));
    }

    // change password page
    public function changePasswordPage(){
        return view('user.password.change');
    }

    // change password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbPassword = $user->password;

        if(Hash::check($request->oldPassword, $dbPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            // Auth::logout;
            return back()->with(['changeSuccess'=>'Password Changed']);
        }
        return back()->with(['notMatch' => 'the Old Password not match, Try Again!']);
    }

    // user account change page
    public function accountChangePage(){
        return view('user.profile.account');
    }

    // user account change
    public function accountChange($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        // for image
        if($request->hasFile('image')){
            // 1 old image name | check => delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image; // get old image

            if($dbImage != null){
                Storage::delete(['public/'.$dbImage]);  // delete old image
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName(); // get new image name
            $request->file('image')->storeAs('public',$fileName);   // store new image at public
            $data['image'] = $fileName; // store new image at database
        }

        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'Admin Account Updated...']);
    }

    // filter pizza
    public function filter($categoryId){
        $pizzas = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizzas','categories','cart','history'));
    }

    // direct pizza details
    public function pizzaDetails($pizzaId){
        $pizza = Product::where('id',$pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details',compact('pizza','pizzaList'));
    }

    // cart list
    public function cartList(){
        $cartLists = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
                ->leftJoin('products','products.id','carts.product_id')
                ->where('carts.user_id',Auth::user()->id)
                ->get();
        $totalPrice = 0;
        foreach($cartLists as $cartList){
            $totalPrice += $cartList->pizza_price*$cartList->qty;
        }

        return view('user.main.cart',compact('cartLists','totalPrice'));
    }

    // direct history page
    public function history(){
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(6);
        return view('user.main.history',compact('orders'));
    }

    // direct contact page
    public function userContactPage($id){
        $user = User::where('id',$id)->first();
        return view('user.contact.page',compact('user'));
    }

    // contact form
    public function userContactForm($id, Request $request){
        $data = $this->getContactData($request);
        $this->contactValidationCheck($request);
        Contact::create($data);
        return redirect()->route('user#home');
    }

    // password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:15',
            'newPassword' => 'required|min:6|max:15',
            'confirmPassword' => 'required|min:6|max:15|same:newPassword'
        ])->validate();
    }

    // account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'address' => 'required'
        ])->validate();
    }

    // request user data
    private function getUserData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }

    // request contact data
    private function getContactData($request){
        $user = User::where('id',Auth::user()->id)->first();
        return [
            'name' => $user->name,
            'email' => $user->email,
            'message' => $request->message
        ];
    }

    // contact validation check
    private function contactValidationCheck($request){
        Validator::make($request->all(),[
            'message' => 'required|min:10'
        ])->validate();
    }
}
