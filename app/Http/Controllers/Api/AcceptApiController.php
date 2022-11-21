<?php

namespace App\Http\Controllers\Api;

use App\Companies;
use App\Http\Controllers\Controller;
use App\Message;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use function response;

class AcceptApiController extends Controller
{
    /**
* @OA\Post (
*     path="/api/admin/sendmessage",
*     tags={"Messages"},
     *security={
     *{
     *"passport": {}},
     *},
*     summary="Add message",
     *     @OA\RequestBody (
     *     required=true,
     *     @OA\JsonContent(
     *     @OA\Examples(
     *        summary="Send message",
     *        example = "Send",
     *       value = {
    *           "phone_number": "994554251296",
     *           "message": "Hi there"
    *         },
     *      )
     *     ),
     * ),
     *     operationId="sendMessage",
     *     @OA\Response(
     *     response=200,
     *     description="Message was sent successfully!",
     *     @OA\JsonContent()
* ),
     * ),
     */
    public function sendMessage(Request $request)
    {
        $request['phone_number'] = preg_replace("/[^0-9,.]/", "",$request['phone_number']);
        $filter = Validator::make($request->all(),[
            'phone_number' => ['required','numeric'],
            'message' => ['required','min:3'],
        ]);
        if($filter->fails()){

            $messages = $filter->messages();
            return response()->json(["errors" => $messages], 422);
        }
                $message=new Message();
                $message=$message->sendMessage(Auth::user()->c_id,$request['phone_number'],$request['message'],1);
                if($message)
                {
                    return response()->json(['status'=>'success','message'=>'The query of message sent','message_id'=>$message],200);
                }else
                {
                    return response()->json(['status'=>'error','message'=>'Message Invalid'],422);
                }
        Log::notice('Send message'.json_encode($request->all()));
        return 'ok';
    }

    /**
     * @param Request $request
     * @param $mId
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get (
     *security={
     *{
     *"passport": {}},
     *},
     *     path="/api/admin/check-message/{id}",
     *     tags={"Messages"},
     *     summary="Check message",
     *     @OA\Parameter (
     *     name="id",
     *     in="path",
     *     description="You have to send id",
     *     required=true,
     *     @OA\Schema (
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Message checked",
     *     @OA\JsonContent(
     *     @OA\Examples(
     *        summary="Success message",
     *        example = "Success message",
     *       value = {
                    "status": "success",
                    "message": "The status of message is success"
                    },
     *      )
     *     )
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\JsonContent()
     * ),
     *     @OA\Response(
     *     response="default",
     *     description="Unexpected error",
     *     @OA\JsonContent()
     * ),
     * ),
     */
    public function checkMessage(Request $request, $mId)
    {
        \Illuminate\Support\Facades\Log::notice('Check message'.json_encode($request->all()));
        $company=Companies::query()->findOrFail(Auth::user()->c_id);
            if ($company){
                $message=Message::query()->findOrFail($mId);
                if($message->send_status_id==1)
                {
                    return response()->json(['status'=>'success','message'=>'The status of message is success'],200);
                }else
                {
                    return response()->json(['status'=>'error','message'=>"Message isn't success"],Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
            else{
                return response()->json('Company is not found.',Response::HTTP_NOT_FOUND);
            }

    }

    /**
     * @param Request $request
     * @param $mId
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get (
     *security={
     *{
     *"passport": {}},
     *},
     *     path="/api/admin/get-all-statistics",
     *     tags={"Messages"},
     *     summary="Get all statistics",
     *     @OA\Response(
     *     response=200,
     *     description="Ok",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Examples(
     *        summary="Example 1",
     *        example = "Response Example",
     *       value = {
     *           "data": {
     *                  "sent": 6666,
                        "unsent": 15552,
                        "invalid": 65059,
                        "expired": 0,
                        "queue": 0
                        },
     *         },
     *      ),
     *     )
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\JsonContent()
     * ),
     *     @OA\Response(
     *     response="default",
     *     description="Unexpected error",
     *     @OA\JsonContent()
     * ),
     * ),
     */
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
            return response()->json(['data'=>[  'sent'=>$sent,
                                                'unsent'=>$unSent,
                                                'invalid'=>$invalid,
                                                'expired'=>$expired,
                                                'queue'=>$queue
            ]],Response::HTTP_OK);
        }else
        {
            return response()->json(['status'=>'error','message'=>"The company doesn't find"],422);
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
                    'send_status_id'=>Message::STATUS_SEND
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
