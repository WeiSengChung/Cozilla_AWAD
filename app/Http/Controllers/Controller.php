<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Cart;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $userProfile = UserProfile::where('user_id', $user->id)->first();

        $userAddresses = Address::where('user_id', $user->id)->get();
        $companyInfo = ContactUs::first();
        return view('profile', compact(['user', 'userProfile', 'userAddresses', 'companyInfo']));
    }

    public function showAddressForm()
    {
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

}
