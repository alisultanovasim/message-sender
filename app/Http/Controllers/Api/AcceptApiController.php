<?php

namespace App\Http\Controllers\Api;

use App\Companies;
use App\Http\Controllers\Controller;
use App\Imports\TestMessageImport;
use App\Jobs\SendMessageJob;
use App\Message;
use App\TestMessage;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use function response;

class AcceptApiController extends Controller
{

    public function sendBatch(Request $request)
    {
        $this->validate($request,[
            'numbers'=>['required','array'],
            'message'=>['required','string']
        ]);

        $company_id=Auth::user()->c_id;
//        dd($company_id);
        $company=Companies::query()->where('id',$company_id)->get(['c_message_limit']);
//        dd($company[0]['c_message_limit']);

        $newArr=[];
        $count=1;
        for($i=0;$i<count($request->numbers);$i++){
            $count=count($request->numbers);
            $request->numbers = preg_replace("/[^0-9,.]/", "",$request->numbers);
//            dd($request->numbers);
            if ((int)$request->numbers[$i][0]===0){
                $request->numbers[$i] = substr_replace($request->numbers[$i], '994', 0, 1);
            }
            $newArr[] = '+' . $request->numbers[$i];
        }

        if ((int)$company[0]['c_message_limit']===1){
            return response()->json(['status'=>'limit_error','message'=>'Limitiniz bitib!'],Response::HTTP_BAD_REQUEST);
        }

        $lastLimit=$company[0]['c_message_limit']-1;
        if ($company[0]['c_message_limit']-$count<=0){
            return response()->json(['status'=>'limit_error','message'=>'Qalan mesaj limitiniz '.$lastLimit.'-dir. Siz limitə uyğun sayda şəxsə mesaj göndərə bilərsiz'],Response::HTTP_BAD_REQUEST);
        }

        $headersOfnumber=['50','51','55','99','55','70','77'];
//        dd($newArr);
        for ($j=0;$j<count($newArr);$j++){
            $headOfNumber=substr($newArr[$j],'4','2');
//            dd($headOfNumber);
            $index=$j+1;
            if (!in_array($headOfNumber,$headersOfnumber)){
                return response()->json(['status'=>'error','message'=>"".$index."-ci nömrə düzgün daxil edilməyib!"]);
            }
        }
        $numString=implode(',',$newArr);
        DB::beginTransaction();

        try {
            $message=new Message();
            $message->senBatchMessage(Auth::user()->c_id,$numString,$request->message,1);

            Companies::query()->findOrFail($company_id)->decrement('c_message_limit',$count);

            DB::commit();
            if ($message){
                return response()->json(['status'=>'Uğurlu','message'=>'Mesaj göndərildi'],Response::HTTP_OK);
            }
            else{
                return response()->json(['status'=>'Uğursuz','message'=>'Mesaj göndərilmədi'],Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response($e->getMessage(),$e->getCode());
        }



    }

    public function import(Request $request)
    {
        $this->validate($request,[
            'excelFile'=>['mimes:xlsx']
        ]);

        if ($request->has('excelFile'))
            Excel::import(new TestMessageImport(), $request->excelFile);

        return 'ok';
    }

    public function send(Request $request)
    {
//        if (!$request->message){
//            return response()->json(['status'=>'error','message'=>'Mesaj daxil edin'],Response::HTTP_BAD_REQUEST);
//        }
        $numbers=TestMessage::query()
            ->whereStatus(1)
            ->get();
        $numArr=[];
        foreach ($numbers as $number){
            array_push($numArr,$number['phone_number']);
        }
        foreach ($numArr as $num){
            $message=new Message();
            $message->sendMessage(1,$num,$request->message,1);
        }
//        $newJob=new SendMessageJob($numbers,$request->message);
//        $this->dispatch($newJob);

        TestMessage::query()
            ->whereStatus(1)
            ->update(['status'=>2]);

        return response()->json(['status'=>'success','message'=>'Ismaric gonderildi'],Response::HTTP_OK);

    }
    public function sendMessage(Request $request)
    {
        $this->validate($request,[
            'phone_number' => ['required','string','min:9','max:13'],
            'message' => ['required','min:3'],
        ]);
        $company_id=Auth::user()->c_id;
        $company=Companies::query()->where('id',$company_id)->get(['c_message_limit']);

        if ((int)$company[0]['c_message_limit']===1){
            return response()->json(['status'=>'limit_error','message'=>'Limitiniz bitib!'],Response::HTTP_BAD_REQUEST);
        }

        $request['phone_number'] = preg_replace("/[^0-9,.]/", "",$request['phone_number']);

        if (strlen($request['phone_number'])===9){
            $request['phone_number']="994".$request['phone_number'];
        }

        if ((int)$request['phone_number'][0]===0){
            $request['phone_number'] = substr_replace($request['phone_number'], '994', 0, 1);
        }

        $headOfNumber=substr($request['phone_number'],'3','2');
        $headersOfnumber=['50','51','55','99','55','70','77'];

        if (in_array($headOfNumber,$headersOfnumber)){
            DB::beginTransaction();

            try {
                $message=new Message();
                $message=$message->sendMessage($company_id,$request['phone_number'],$request['message'],1);
                Companies::query()->findOrFail($company_id)->decrement('c_message_limit',1);

                Log::notice('Send message'.json_encode($request->all()));
                DB::commit();
                if($message)
                {
                    return response()->json(['status'=>'Uğurlu','message'=>'Mesaj uğurla göndərildi','message_id'=>$message],200);
                }
                else{
                    return response()->json(['status'=>'Uğursuz','message'=>'Mesaj uğursuzdur!'],Response::HTTP_BAD_REQUEST);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response($e->getMessage(),$e->getCode());
            }

        }
        else{
            return response()->json(['message'=>'Nömrə düzgün daxil edilməyib!','status'=>'Error'],Response::HTTP_BAD_REQUEST);
        }
    }

    public function checkMessage(Request $request, $mId)
    {
        \Illuminate\Support\Facades\Log::notice('Check message'.json_encode($request->all()));
        $company=Companies::query()->findOrFail(Auth::user()->c_id);
        if ($company){
            $message=Message::query()->findOrFail($mId);
            if($message->send_status_id==1)
            {
                return response()->json(['status'=>'Uğurlu','message'=>'Bu mesajın statusu uğurludur'],200);
            }else
            {
                return response()->json(['status'=>'Uğursuz','message'=>"Mesaj uğursuzdur"],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        else{
            return response()->json('Company is not found.',Response::HTTP_NOT_FOUND);
        }

    }
    public function getStatistics(Request $request)
    {
        $company=Companies::where('c_email',Auth::user()->email)->first();
        if($company)
        {
            Log::notice('Send message'.json_encode($request->all()));
            $sent=Message::query()
                ->where([
                    'c_id'=>$company->id,
                    'send_status_id'=>1
                ])
                ->count();
            $unSent=Message::query()
                ->where([
                    'c_id'=>$company->id,
                    'send_status_id'=>2
                ])
                ->count();
            $invalid=Message::query()
                ->where([
                    'c_id'=>$company->id,
                    'send_status_id'=>3
                ])
                ->count();
            $expired=Message::query()
                ->where([
                    'c_id'=>$company->id,
                    'send_status_id'=>4
                ])
                ->count();
            $queue=Message::query()
                ->where([
                    'c_id'=>$company->id,
                    'send_status_id'=>5
                ])
                ->count();
            return response()->json(['data'=>[  'Göndərildi'=>$sent,
                'Göndərilmədi'=>$unSent,
                'Ləğv edildi'=>$invalid,
                'Müddəti bitdi'=>$expired,
                'Növbədə'=>$queue
            ]],Response::HTTP_OK);
        }else
        {
            return response()->json(['status'=>'error','message'=>"Şirkət tapılmadı"],422);
        }
    }

    public function dateFilter(Request $request)
    {
        $company=Companies::where('c_email',$request['login'])->first();
        if($company)
        {
            if(!Hash::check($request['password'],$company->c_password))
            {
                return response()->json(['status'=>'error','message'=>'The password is wrong'],422);
            }
            Log::notice('Send message'.json_encode($request->all()));
            $count=Message::query()
                ->where([
                    'c_id'=>$company->id,
                    'send_status_id'=>Message::SENT
                ])
                ->whereDate('message_sent_at','>=',$request->from)
                ->whereDate('message_sent_at','<=',$request->to)
                ->count();
            return response(['count'=>$count],Response::HTTP_OK);
        }else
        {
            return response()->json(['status'=>'error','message'=>"The company doesn't find"],422);
        }
    }

}
