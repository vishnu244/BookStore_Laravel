<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function addAddress(Request $request){
        $request->validate([
            "address" => 'required|string|min:5|max:150',
            "landmark" => "required|string|min:5|max:100",
            "city" => "required|string|min:5|max:15",
            "state" => "required|string",
            "pincode" => "required|string",
            "address_type" => "required"
        ]);

        $getUser = $request->user()->id;
        $address = new Address();
        $address->user_id = $getUser;
        $address->address = $request->input('address');
        $address->landmark = $request->input('landmark');
        $address->city = $request->input('city');
        $address->state = $request->input('state');
        $address->pincode = $request->input('pincode');
        $address->address_type = $request->input('address_type');

        $address->save();
        if($address)
        {
        return response()->json(["message"=>"Address added successfully"],201);
        Log::channel('custom')->info("Address added successfully");
        }
        else
        {
        return response()->json(['Message' => "Address not added"],401);
        Log::channel('custom')->info("Address not added");       
        }
    }


    public function update_Address_Id(Request $request){
        $request->validate([
            'id' => 'required|integer',
            "address" => 'required|string|min:5|max:150',
            "landmark" => "required|string|min:5|max:100",
            "city" => "required|string|min:5|max:15",
            "state" => "required|string",
            "pincode" => "required|string",
            "address_type" => "required|string"
        ]);

        $getUser = $request->user()->id;
        $response = DB::table('addresses')->where('id', $request->id)->update(['user_id'=>$getUser,'address'=>$request->address, 'landmark'=>$request->landmark,
                            'city'=>$request->city, 'state'=>$request->state, 'pincode'=>$request->pincode, 'address_type'=>$request->address_type]);

        if($response){
            return response()->json(["message"=>"Address Updated successfully"],201);
            Log::channel('custom')->info("Address Updated successfully");
        }
        else{
            return response()->json(['Message' => "Address not Updated check the ID"],401);
            Log::channel('custom')->error("Address not Updated check the ID");
        }
    }


    public function display_AllAddresses(){
        $Address = Address::all();
        if($Address)
        {
            return response()->json(['success' => $Address],201);
            Log::channel('custom')->info("Address Displayed successfully");
    
        }
        else
        {
            return response()->json(['Message' => "No Address found to display"],401);
            Log::channel('custom')->info("No Address found to display");
        }
    }

   
    public function delete_Address_ID(Request $request){
        $request->validate([
            'id'=>'required|integer'
        ]);

        $response = DB::table('addresses')->where('id', $request->id)->delete();
        if($response){
            return response()->json(["message"=>"Address deleted"],201);
        }
        else{
            Log::channel('custom')->error("You entered invalid id");
        }
    }
}
