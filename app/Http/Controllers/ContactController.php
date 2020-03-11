<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $all_contact = Contact::all();
        return view('auth/contact/index',compact('all_contact'));
    }

    public function delete(Request $request, $id)
    {
        $item = Contact::find($id);
        $item->delete();
        return redirect('/home/contact');
    }
}
