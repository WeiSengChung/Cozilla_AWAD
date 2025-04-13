<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function view(){
        $contact = ContactUs::first();
        return view('admin.manageContactUs', compact ('contact'));
    }

    //update the contact us information
    public function update(Request $request)
    {
        $request->validate([
            'company_address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
        ]);        

        $contact = ContactUs::first();

        if ($contact) {
            $contact -> update ($request -> only (['company_address', 'email', 'contact_number']));
        } else {
            ContactUs::create($request->only(['company_address', 'email', 'contact_number']));
        }

        return redirect ()-> route('manageContactUs') -> with ('message', 'Contact informatin updated successfully !');
    }
}
