<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // direct contact page
    public function adminContactPage(){
        $users = Contact::paginate(5);
        return view('admin.contact.page',compact('users'));
    }

}
