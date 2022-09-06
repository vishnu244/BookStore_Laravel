<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PasswordReset;
use App\Models\User;
use App\Mail\sendmail;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Illuminate\Support\Str;



class PasswordController extends Controller
{


    /**
     * @OA\POST(
     *   path="/api/changePassword",
     *   summary="Change Password",
     *   description="Changing Password in Postman",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email","password", "newPassword"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="newPassword", type="password"),
     *               
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=200, description="password updated successfully"),
     *   @OA\Response(response=400, description="Check your old password"),
     *   
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */



    //API for changing password in postman
    public function changePassword(Request $request){
        $request->validate([
            'email' => 'required',
            'password' =>'required',
            'newPassword' => 'required'
        ]);
        $result = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($result){
            User::where('id', $request->userId)->update(['password' => Hash::make($request->newPassword)]);
            return response()->json(['message'=>"password updated successfully", 'status'=>200]);
            
        }
        else{
            return response()->json(['message'=>"Check your old password", 'status'=>400]);
        }
    }


     /**
     * @OA\POST(
     *   path="/api/forgotPassword",
     *   summary="forgotPassword ",
     *   description="Resetting Password using forgotPassword function",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email"},
     *               @OA\Property(property="email", type="email"),          
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=200, description="Token Sent to Mail to Reset Password"),
     *   @OA\Response(response=404, description="Email does not exists"),
     *   
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */

//--- sending token to mail to change password -------
    public function forgotPassword(Request $request)
    {  
        
         $request->validate([
            'email'=>'required | max:200',         
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['Message' => "Email does not exists", 'status' => 404]);
            
        } 
        else {

            $token = Str::random(10);
            $reset = new PasswordReset();

            PasswordReset::create([
                'email' => $request->email,
                'token' => $token
            ]);

            Mail::to($email)->send(new SendMail($token, $email));
            
            return "Token Sent to Mail to Reset Password";
            
        }
    
    }



    /**
     * @OA\POST(
     *   path="/api/resetPassword",
     *   summary="Resetting Password",
     *   description="Resetting Password through Token",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email","password", "token"},
     *               @OA\Property(property="email", type="string"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="token", type="string"),
     *               
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=200, description="password Reset successfull"),
     *   @OA\Response(response=401, description="You have entered invalid token"),
     *   
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */




    //API to Reset the Password using Token sent to mail
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'token' => 'required'
        ]);

        $passwordReset = PasswordReset::where('token', $request->token)->first();
        if(!$passwordReset){
            return response()->json(['message' => "Token is invalid "]);
        }

        $user = User::where('email', $passwordReset->email)->first();
        $user->password = Hash::make($request->password);

        PasswordReset::where('email', $request->email)->delete();
        return "password Reset successfull";
      
    }
}
