<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Companies;
use App\Message;
use App\Logs;

use Auth;

class CompanyController extends Controller
{
    public function editCompany()
    {
        $company=Companies::where('id',Auth::user()->c_id)->first();
        return view('company.edit',compact('company'));
    }
    public function editCompanyPost(Request $request)
    {
        $company=Companies::where('id',Auth::user()->c_id)->first();
        if($company)
        {
            Companies::where('id',$company->id)->update([
                'c_name'=>$request['c_name'],
                'c_phone_call'=>$request['c_phone_call'],
                'c_person_charge'=>$request['c_person_charge'],
                'c_address'=>$request['c_address'],
                'c_environment_id'=>$request['c_environment_id'],
            ]);
            if($request['c_password'])
            {
                Companies::where('id',$company->id)->update([
                    'c_password'=>$request['c_password']
                ]);
            }
            $array=array(
                 'companies_name'=>$company->c_name,
                 'log_type'=>'Edit_Company',
                 'log_text'=>'Request: '.json_encode($request->all()),
                 'ip'=>getServerIp()
                );
            saveLog($array);
            return back();

        }
    }
    public function checkNumber()
    {
        $message=new Message();
        $message=$message->checkWhatsappNumber(Auth::user()->c_id);
        return response()->json(['status'=>'success','message'=>$message]);
    }
    public function checkNumberProfile()
    {
        $messageLimit=Companies::query()
            ->where('id',Auth::user()->c_id)
            ->get(['c_message_limit']);
        $message=new Message();
        $message=$message->checkNumberProfile(Auth::user()->c_id);
        return view('company.profile',compact(['message','messageLimit']));
    }
}
