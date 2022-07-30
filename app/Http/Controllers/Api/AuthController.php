<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VendorDetail;
use App\Models\ReferralEarn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function checkPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
        }
        if (! $user = User::where('phone', $request['phone'])->select('id')->first())
        {
            return response()->json(['status' => 200, 'message' => 'Phone number available.'], 200);
        }
        return response()->json(['status' => 201, 'message' => 'Phone number already exist' ], 200);
    }
    public function checkemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
        }
        if (! $user = User::where('email', $request['email'])->select('id')->first())
        {
            return response()->json(['status' => 200, 'message' => 'E-mail available.' ], 200);
        }
        return response()->json(['status' => 201, 'message' => 'E-mail already exist' ], 200);
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname'  => 'required',
                'phone'     => "required|unique:users,phone",
                'email'     => "required|email|unique:users,email",
                'password'  => 'required',
            ]);
            if ($validator->fails()) {
                // return response()->json(['status' => 201, 'message' =>  implode(', ', $validator->messages()->all())], 200);
                return response()->json(['status' => 201, 'message' =>  $validator->errors()->first()], 200);
            }
            $code = $this->generateUniqueReferralCode();
            if ($user = User::create([
                'name' => isset($request->firstname) ? $request->firstname. ' '.$request->lastname : '',
                'firstname' => isset($request->firstname) ? $request->firstname : '',
                'lastname' => isset($request->lastname) ? $request->lastname : '',
                'email' => isset($request->email) ? $request->email : null,
                'password' => isset($request->password) ? Hash::make($request->password) : '',
                'phone' => isset($request->phone) ? $request->phone : null,
                'type' => isset($request->type) ? $request->type : 'User',
                'profile' => null,
                'referral_code' => $code,
                'active' => 'Y'
            ])) {

                $users = DB::table('users')->select('*')->where('email', $request->email)->first();
                $otp = rand(1000, 9999);
                // $html = 'Your otp for reset password:-' . $otp;
                // Mail::send([], [], function ($message) use ($html, $request) {
                    Mail::send('email.emailverify',['otp' => $otp], function($message) use ($request) {
                    $message->to($request->email)
                        ->subject('verify your email');
                        // ->from('jr.laravelpixbrand@gmail.com')
                        // ->setBody($html);
                });

                DB::table('users')->where('email', $request->email)->update(array(
                    'otp' => $otp,
                ));
                $token = $user->createToken('94b2f892-2c7c-4bf4-8043-cf9cf6cc4c70')->accessToken;
                $data = userInfoResponse($user->id);
                $user->assignRole('User');
                $data['token'] = $token;
                if($request->referral_code)
                {
                    $referralby = DB::table('users')->where('referral_code', $request->referral_code)->pluck('id')->first();
                    ReferralEarn::updateOrCreate(['referralto'   => $user->id],[
                            'referralby'    => $referralby,
                            'referralto'    => $user->id,
                            'referral_code' => $request->referral_code,
                            'email'         => $request->email,
                            'phone'         => $request->phone,
                            'referral_date' => date('Y-m-d'),
                    ]);
                }
                return response()->json(['status' => 200, 'message' => 'Registered successful', 'data' => $data, 'otp' => $otp], 200);
            }

            return response()->json(['status' => 201, 'message' => 'Error in user registertion'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }

    public function emailOtpRequest(Request $request)
    {
        // $user = $request->user();
        $validator = Validator::make($request->all(), [
                'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
        }
        if ($user = User::where('email', $request->email)->first())
        {
            $otp = rand(1000, 9999);
            $user->update(['otp' => $otp]);
            $message = $otp." is your OTP for application Tranquille";
            // $this->sendMessage($message, $user->mobile_code.' '.$user->phone);
            Mail::send([], [], function ($data) use ($message, $user) {
                            $data->to($user->email)
                    ->subject('verify your email')
                    ->from('srbackendpixbrand@gmail.com')
                    ->setBody($message);
            });
            return response()->json(['status' => 200, 'message' => 'Otp has been send successfully.' , 'OTP' => $otp ], 200);
        }
        return response()->json(['status' => 201, 'message' => 'Error in send otp' ], 200);
    }
    public function phoneOtpRequest(Request $request)
    {
        // $user = $request->user();
        $validator = Validator::make($request->all(), [
                'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
        }
        if ($user = User::where('phone', $request->phone)->first())
        {
            $otp = rand(1000, 9999);
            $user->update(['otp' => $otp]);
            $message = $otp." is your OTP for application Tranquille";
            // $this->sendMessage($message, $user->mobile_code.' '.$user->phone);
            Mail::send([], [], function ($data) use ($message, $user) {
                            $data->to($user->email)
                    ->subject('verify your email')
                    ->from('srbackendpixbrand@gmail.com')
                    ->setBody($message);
            });
            return response()->json(['status' => 200, 'message' => 'Otp has been send successfully.' , 'OTP' => $otp ], 200);
        }
        return response()->json(['status' => 201, 'message' => 'Error in send otp' ], 200);
    }

    public function verifyEmailOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp'   => 'required',
            'email'     => "required|email",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
        }
        if ($user = User::where('email', $request->email)->where('otp', '=',$request->otp)->update([ 'email_verified' => true]))
        {
            $userinfo = User::where('email', $request->email)->where('otp', '=',$request->otp)->first();
            unset($userinfo['password']);
            $token = $userinfo->createToken('94b2f892-2c7c-4bf4-8043-cf9cf6cc4c70')->accessToken;
            $data = userInfoResponse($userinfo->id);
            $data['token'] = $token;
            return response()->json(['status' => 200, 'message' => 'Otp matched succesfull','data' => $data ], 200);
            // return response()->json(['status' => 200, 'message' => 'Otp matched succesfull'], 200);
        }
        return response()->json(['status' => 201, 'message' => 'Otp not matched' ], 200);
    }

    public function verifyPhoneOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp'   => 'required',
            'phone'     => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
        }
        if ($user = User::where('phone', $request->phone)->where('otp', '=',$request->otp)->update([ 'email_verified' => true]))
        {
            return response()->json(['status' => 200, 'message' => 'Otp matched succesfull'], 200);
        }
        return response()->json(['status' => 201, 'message' => 'Otp not matched' ], 200);
    }
    public function changePassword(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'oldpassword'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $user = User::find($userid);
            if (Hash::check($request['oldpassword'],$user['password']) ) {
                $user->password = isset($request->password) ? Hash::make($request->password) : '';
                if ($user->save()) {
                    return response()->json(['status' => 200, 'message' => 'Password Changed' ], 200);
                }
                return response()->json(['status' => 201, 'message' => 'Error in user registertion' ], 200);
            }
            return response()->json(['status' => 201, 'message' => "Old password dosen't match" ], 200);

        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function getuserInfo(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $data = userInfoResponse($userid);
            if(!empty($data))
            {
                return response()->json(['status' => 200, 'message' => 'User found','data' => $data ], 200);
            }
             return response()->json(['status' => 201, 'message' => 'Error in data retrieved' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname'  => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $user = User::where('id', $userid)->select('id','active', 'firstname', 'lastname', 'profile', 'email', 'phone')->first();
            $user->name = isset($request->firstname) ? $request->firstname. ' '.$request->lastname : '';
            $user->firstname = isset($request->firstname) ? $request->firstname : '';
            $user->lastname = isset($request->lastname) ? $request->lastname : '';
            $user->dob = isset($request->dob) ? $request->dob : null;
            $user->language = isset($request->language) ? $request->language : '';
            $user->country = isset($request->country) ? $request->country : '';
            if ($request->file('user_image') != null) {
                removeFileFromPath($user->profile);
                $imagepath = uploadImageToPath($request->user_image , 'profile');
                $user->profile = $imagepath;
            }
            if ($user->save()) {
               $data = userInfoResponse($user->id);
                return response()->json(['status' => 200, 'message' => 'Profile updated succesfully','data' => $data ], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in profile update' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function profileimageUpdate(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'image' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if ($request->file('image') != null) {
                removeFileFromPath($request->user()->profile);
            }
            $imagepath = uploadImageToPath($request->image , 'profile');
            if(User::where('id', $userid)->update([
                "image" => $imagepath
            ]))
            {
                return response()->json(['status' => 200, 'message' => 'Profile updated succesfully'], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in profile update' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function login(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            $email = $request->input('email');
            $password = $request->input('password');
            if (! $user = User::where('email', $email)->select('id','email', 'password','active', 'phone', 'type','device_token', 'email_verified', 'phone_verified')->first()) {
                return response()->json(['status' => 201, 'message' => 'User not found' ], 200);
            }
            if($user->active != 'Y')
            {
                return response()->json(['status' => 201, 'message' => 'You have been blocked by admin' ], 200);
            }
            // if($user->email_verified == 0)
            // {
            //     return response()->json(['status' => 201, 'message' => 'Please verify your email first.' ], 200);
            // }
            // if($user->phone_verified == 0)
            // {
            //     return response()->json(['status' => 201, 'message' => 'Please verify your phone number first.' , 'phone' => $user->phone], 200);
            // }
            if (Hash::check($password,$user['password']) ) {
                unset($user['password']);
                $token = $user->createToken('94b2f892-2c7c-4bf4-8043-cf9cf6cc4c70')->accessToken;
                $user->update(['device_token' => isset($request->device_token) ? $request->device_token : '']);
                $data = userInfoResponse($user->id);
                $data['token'] = $token;
                return response()->json(['status' => 200, 'message' => 'Login Successs','data' => $data ], 200);
            }
            else
            {
                return response()->json(['status' => 201, 'message' => 'Password not match' ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function forgetPassword(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'email'     => "required|email"
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if (! $user = User::where('email', $request->email)->select('id','active', 'firstname', 'lastname', 'email', 'phone')->first()) {
                return response()->json(['status' => 201, 'message' => 'User not found' ], 200);
            }
            $otp = rand(1000, 9999);
            $user->otp = $otp;
            if($user->save() )
            {
                $message = $otp." is your OTP for application Tranquille";
                // $this->sendMessage($message, $user->mobile_code.' '.$user->phone);
                Mail::send([], [], function ($data) use ($message, $user) {
                                $data->to($user->email)
                        ->subject('verify your email')
                        ->from('srbackendpixbrand@gmail.com')
                        ->setBody($message);
                });
                return response()->json(['status' => 200, 'message' => 'Otp has been send successfully.' , 'OTP' => $otp ], 200);
            }
             return response()->json(['status' => 201, 'message' => 'Error in send otp' ], 200);
            //  $token = Str::random(64);
            //  $user->sendPasswordResetNotification($token);
            // return response()->json(['status' => 200, 'message' => 'Reset Link has been send to your registered email'], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }
    public function socialLogin(Request $request)
    {

        try
        {
            $validator = Validator::make($request->all(), [
                'social_id' => "required",
                'socialtype'  => 'required',
                'firstname'     => 'required',
                //'lastname'      => 'required',
                'email'         => "required|email",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if( $user = User::where('email', $request->email)->select('id','device_token', 'email', 'social_id', 'socialtype')->first() )
            {
               $token = $user->createToken('94b2f892-2c7c-4bf4-8043-cf9cf6cc4c70')->accessToken;
                $user->update([
                    'device_token' => isset($request->device_token) ? $request->device_token : '',
                    'social_id' => isset($request->social_id) ? $request->social_id : '',
                    'socialtype' => isset($request->socialtype) ? $request->socialtype : ''
                ]);
                $data = userInfoResponse($user->id);
                $data['token'] = $token;
                return response()->json(['status' => 200, 'message' => 'Login Successs','data' => $data ], 200);
            }
            else if ($user = User::where('phone', $request->phone)->select('id','device_token', 'email', 'social_id', 'socialtype')->first()) {
                $user->update([
                    'device_token' => isset($request->device_token) ? $request->device_token : '',
                    'social_id' => isset($request->social_id) ? $request->social_id : '',
                    'socialtype' => isset($request->socialtype) ? $request->socialtype : ''
                ]);
                $token = $user->createToken('94b2f892-2c7c-4bf4-8043-cf9cf6cc4c70')->accessToken;
                $data = userInfoResponse($user->id);
                $data['token'] = $token;
                return response()->json(['status' => 200, 'message' => 'Login Successs','data' => $data ], 200);
            }
            else
            {
                if ($user = User::create([
                    'name' => isset($request->firstname) ? $request->firstname. ' '.$request->lastname : '',
                    'firstname' => isset($request->firstname) ? $request->firstname : '',
                    'lastname' => isset($request->lastname) ? $request->lastname : '',
                    'email' => isset($request->email) ? $request->email : null,
                    'password' => isset($request->password) ? Hash::make($request->password) : '',
                    'phone' => isset($request->phone) ? $request->phone : null,
                    'type' => isset($request->type) ? $request->type : 'User',
                    'profile' => null,
                    'device_token' => isset($request->device_token) ? $request->device_token : '',
                    'social_id' => isset($request->social_id) ? $request->social_id : null,
                    'socialtype' => isset($request->socialtype) ? $request->socialtype : null,
                ])) {
                    $token = $user->createToken('94b2f892-2c7c-4bf4-8043-cf9cf6cc4c70')->accessToken;
                    $data = userInfoResponse($user->id);
                    $data['token'] = $token;
                    $user->assignRole('User');
                    return response()->json(['status' => 200, 'message' => 'Registered succesfull','data' => $data ], 200);
                }
                return response()->json(['status' => 201, 'message' => 'Error in user registertion' ], 200);
            }

            return response()->json(['status' => 201, 'message' => 'Error in user registertion' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
         try
        {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }

            if (User::where('email','=', $request->email)->update([ 'password' => Hash::make($request->password)])) {
                return response()->json(['status' => 200, 'message' => 'Password Reset Successfully' ], 200);
            }
            return response()->json(['status' => 201, 'message' => "Error in Reset Password" ], 200);

        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function receivedNotification(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'notified' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if(User::where('id', $userid)->update([
                "notified" => $request->notified
            ]))
            {
                return response()->json(['status' => 200, 'message' => 'Update Notification succesfull'], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in Notification update' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function setLanguage(Request $request)
    {
        try
        {
            $userid = $request->user()->id;
            $validator = Validator::make($request->all(), [
                'language' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  implode(', ',$validator->messages()->all())], 200);
            }
            if(User::where('id', $userid)->update([
                "language" => $request->language
            ]))
            {
                return response()->json(['status' => 200, 'message' => 'Update language succesfull'], 200);
            }
            return response()->json(['status' => 201, 'message' => 'Error in language update' ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 201, 'message' => $e->getMessage() ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user()->token();
        if ($user->revoke()) {
            return response()->json(['status' => 200, 'message' => 'Logout Successs',], 200);
        }
        else
        {
            return response()->json(['status' => 201, 'message' => 'Error in Logout' ], 200);
        }
    }
    public function generateUniqueReferralCode()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($permitted_chars), 0, 10);
        if (User::where('referral_code', '=', $code)->exists()) {
            $this->generateUniqueReferralCode();
        }
        return $code ;
    }
    public function AddNewClient(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname'  => 'required',
                'phone'     => "required|unique:users,phone",
                'email'     => "required|email|unique:users,email",
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 201, 'message' =>  $validator->errors()->first()], 200);
            }
            $code = $this->generateUniqueReferralCode();
            if ($user = User::create([
                'name' => isset($request->firstname) ? $request->firstname. ' '.$request->lastname : '',
                'firstname' => isset($request->firstname) ? $request->firstname : '',
                'lastname' => isset($request->lastname) ? $request->lastname : '',
                'email' => isset($request->email) ? $request->email : null,
                'password' => isset($request->password) ? Hash::make($request->password) : '',
                'phone' => isset($request->phone) ? $request->phone : null,
                'type' => isset($request->type) ? $request->type : 'User',
                'profile' => null,
                'referral_code' => $code,
                'active' => 'Y'
            ])) {
                ReferralEarn::updateOrCreate(['referralto'   => $user->id],[
                    'referralby'    => $request->user()->id,
                    'referralto'    => $user->id,
                    'referral_code' => $request->user()->referral_code,
                    'email'         => $request->email,
                    'phone'         => $request->phone,
                    'referral_date' => date('Y-m-d'),
                ]);
                return response()->json(['status' => 200, 'message' => 'Client Added succesfull', 'data' => $user], 200);
            }

            return response()->json(['status' => 201, 'message' => 'Error in user registertion'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 201, 'message' => $e->getMessage()], 500);
        }
    }
}
