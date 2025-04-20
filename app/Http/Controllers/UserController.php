<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\ContactUs;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function profile()
    {
        if (! Auth::check()) {
            return redirect('/login')->with('message', "You must log in to access your account.");
        }
        $user = Auth::user();
        $userProfile = UserProfile::where('user_id', $user->id)->first();

        $userAddresses = Address::where('user_id', $user->id)->get();
        $companyInfo = ContactUs::first();
        return view('profile', compact(['user', 'userProfile', 'userAddresses', 'companyInfo']));
    }

    public function showAddressForm()
    {
        if (! Auth::check()) {
            return redirect('/login')->with('message', "You are not authenticated, please log in!");
        }
        return view('add_address');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'street' => 'required|string|max:20',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'postcode' => 'required|string|max:20',
        ]);

        $user = Auth::user();

        //check if profile exists, or create a new one
        $fullAddress = "{$request->street}, {$request->city}, {$request->state}, {$request->postcode}";

        $address = new Address();
        $address->user_id = $user->id;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postcode = $request->postcode;
        $address->save();

        return redirect()->route('profile')->with('success', 'Address saved successfully!');
    }

    public function getAddress($id)
    {
        $address = Address::findOrFail($id);
        return response()->json($address);
    }

    public function editAddress(Request $request, $id)
    {
        $address = Address::findOrFail($id);
        $address->street = $request->input('street');
        $address->city = $request->input('city');
        $address->state = $request->input('state');
        $address->postcode = $request->input('postcode');
        $address->save();
        return redirect()->route('profile')->with('success', 'Address updated successfully!');
    }

    public function updateProfile(Request $request, $userProfileId)
    {
        $userProfile = UserProfile::findOrFail($userProfileId);
        $userProfile->first_name = $request->input('first_name');
        $userProfile->last_name = $request->input('last_name');
        $userProfile->save();
        $user = Auth::user();
        $user->email = $request->input('email');
        $user->save();
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function deleteAddress(Request $request, $id)
    {
        if (! Auth::check()) {
            return redirect('login')->with('message', "You are not authenticated, please log in!");
        }
        $address = Address::findOrFail($id);
        if (Auth::id() !== $address->user_id) {
            return redirect(route('profile'))->with('success', "You are not authorized to delete other addresses!");
        }

        $address->delete();
        return redirect()->route('profile')->with('success', 'Address deleted successfully!');
    }
}
