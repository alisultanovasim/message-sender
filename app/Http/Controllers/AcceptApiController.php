<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Hash;
use Validator;

use App\Companies;
use App\Messages;

class AcceptApiController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request['phone_number'] = preg_replace("/[^0-9,.]/", "",$request['phone_number']);
        $filter = Validator::make($request->all(),[
            'login' => ['required'],
            'password' => ['required'],
            'phone_number' => ['required',],
            'message' => ['required','min:3'],
        ]);
        if($filter->fails()){
            
            $messages = $filter->messages();
            return response()->json(["errors" => $messages], 422);
        }
        $company=Companies::where('c_email',$request['login'])->first();
        if($company)
        {
            if(Hash::check($request['password'],$company->c_password))
            {
                $message=new Messages();
                $message=$message->sendMessage($company->id,$request['phone_number'],$request['message'],1);
                if($message)
                {
                    return response()->json(['status'=>'success','message'=>'The query of message sent','message_id'=>$message],200);
                }else
                {
                    return response()->json(['status'=>'error','message'=>'Message Invalid'],422);
                }
            }else
            {
                return response()->json(['status'=>'error','message'=>'The password is wrong'],422);
            }
        }else
        {
            return response()->json(['status'=>'error','message'=>"The company doesn't find"],422);
        }
        Log::notice('Send message'.json_encode($request->all()));
        return 'ok';
    }
    public function checkMessage(Request $request)
    {
        $filter = Validator::make($request->all(),[
            'login' => ['required'],
            'password' => ['required'],
            'message_id' => ['required'],
        ]);
        if($filter->fails()){
            
            $messages = $filter->messages();
            return response()->json(["errors" => $messages], 422);
        }
        
        Log::notice('Check message'.json_encode($request->all()));
        $company=Companies::where('c_email',$request['login'])->first();
        if($company)
        {
            if(Hash::check($request['password'],$company->c_password))
            {
                $message=Messages::where('id',$request['message_id'])->first();
                if($message)
                {
                    if($message->send_status_id==1)
                    {
                        return response()->json(['status'=>'success','message'=>'The status of message is success'],200);
                    }else
                    {
                        return response()->json(['status'=>'error','message'=>"Message isn't success"],422);
                    }
                }else
                {
                    return response()->json(['status'=>'error','message'=>'Message not found'],422);
                }
            }else
            {
                return response()->json(['status'=>'error','message'=>'The password is wrong'],422);
            }
        }else
        {
            return response()->json(['status'=>'error','message'=>"The company doesn't find"],422);
        }
        return 'ok';
    }
}
