<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messages;
use App\ChatType;
use App\SendStatus;
use App\MessageStatus;
use App\Priority;
use App\Commands;
use App\CommandImages;
use App\CommandVideos;
use App\CommandAddress;
use App\CommandMessages;

use Auth;
use Cache;

class MessagesController extends Controller
{
    public function addmessage()
    {
        return view('messages.add');
    }
    public function addmessagepost(Request $request)
    {
        $company_id=Auth::user()->c_id;
        if($company_id)
        {
            $message=new Messages();
            $message=$message->sendMessage($company_id,$request['telephone'],$request['message'],2);
            if($message)
            {
                return response()->json(['status'=>'success','message'=>'The query of message sent']);
            }
        }else
        {
            return response()->json(['status'=>'error','message'=>'Sizin şirkət hesabı aktiv deyil']);
        }
    }
    public function messages(Request $request)
    {
        $company=Auth::user();
        $messages=Messages::orderBy('id','desc');
        if($company->id!=1  && $company->id!=2)
        {
            $messages=$messages->where('c_id',$company->c_id);
        }
        if($request['from_message'])
        {
            $messages=$messages->where('from_message',$request['from_message']);
        }
        if($request['to_message'])
        {
            $messages=$messages->where('to_message',$request['to_message']);
        }
        if($request['chat_type_id']!=0 && $request['chat_type_id']!=null)
        {
            $messages=$messages->where('chat_type_id',$request['chat_type_id']);
        }
        if($request['send_status_id']!=0 && $request['send_status_id']!=null)
        {
            $messages=$messages->where('send_status_id',$request['send_status_id']);
        }
        if($request['message_status_id']!=0 && $request['message_status_id']!=null)
        {
            $messages=$messages->where('message_status_id',$request['message_status_id']);
        }
        if($request['priority_id']!=0 && $request['priority_id']!=null)
        {
            $messages=$messages->where('priority_id',$request['priority_id']);
        }
        if($request['bir'] && $request['iki'])
        {
            $start = date("Y-m-d",strtotime($request['bir']));
            $end = date("Y-m-d",strtotime($request['iki']."+1 day"));
            $messages=$messages->whereBetween('message_created_at',[$start,$end]);
        }
        $date1=$request['bir'];
        $date2=$request['iki'];
        if($request['bir'] && $request['iki'])
        {
            $date1=date("Y-m-d",strtotime($request['bir']));
            $date2=date("Y-m-d",strtotime($request['iki']));
        }
        if($request['export'])
        {
            $array=$messages->get();
            $filename = "messages.csv";
            
          $headers = array(
            "Content-Encoding"    => "UTF-8",
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
          );
          $columns = array('Client', 'Text', 'Message_Type', 'Send_Status','Message_Status','Priority','Send_date');

          $callback = function() use($array, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);
            foreach ($array as $task) {
                $row['Client']  = $task->to_message;
                $row['Text']    = $task->body_message;
                $row['Message_Type']    = $task->chatType['title'];
                $row['Send_Status']  = $task->sendStatus['title'];
                $row['Message_Status']  = $task->messageStatus['title'];
                $row['Priority']  = $task->priority['title'];
                $row['Send_date']  = date('d.m.Y H:i:s',strtotime($task->message_sent_at));

                fputcsv($file, array($row['Client'], $row['Text'], $row['Message_Type'], $row['Send_Status'], $row['Message_Status'], $row['Priority'], $row['Send_date']));
            }
            // mb_convert_encoding($file, 'UTF-16', 'UTF-8');
             fclose($file);
          };
            return response()->stream($callback, 200, $headers);
            exit();
        }
        $from_message=$request['from_message'];
        $to_message=$request['to_message'];
        $m_status=$request['message_status_id'];
        $s_status=$request['send_status_id'];
        $type=$request['chat_type_id'];
        $priority=$request['priority_id'];
        $messages=$messages->paginate(20);
        $chatypes=ChatType::where('type_status',1)->get();
        $sendtstauses=SendStatus::where('type_status',1)->get();
        $messagestatuses=MessageStatus::where('type_status',1)->get();
        $priorities=Priority::where('type_status',1)->get();
        $page=$request['page'] ? $request['page'] : 1;
        if($request['page']==null)
        {
            $currentpage=1;
        }else
        {
            $currentpage=$request['page'];
        }
        $currentpage=($currentpage-1)*20;
        return view('messages.index',compact('from_message','to_message','type','s_status','m_status','priority','date1','date2','messages','page','currentpage','priorities','messagestatuses','sendtstauses','chatypes'));
    }
    public function checkmessages(Request $request)
    {
        $company=Auth::user();
        $count=Messages::count();
        if($company->id!=1  && $company->id!=2)
        {
            $count=Messages::where('c_id',$company->c_id)->count();
        }
        if($count%20==0)
        {
            $totalpage=$count/20;
        }else
        {
            $totalpage=intval($count/20)+1;
        }
        return response()->json(['status'=>'success','count'=>$totalpage]);
    }
    public function statics()
    {
        $statics=new Messages();
        $statics=$statics->getSendStatics(Auth::user()->c_id);
        return view('index',compact('statics'));
    }
    public function downloadExcel($array)
    {
        $filename = "messages.csv";
            
        $headers = array(
            "Content-Encoding"    => "UTF-8",
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
          );
          $columns = array('Client', 'Text', 'Message_Type', 'Send_Status','Message_Status','Priority','Send_date');

          $callback = function() use($array, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);
            foreach ($array as $task) {
                $row['Client']  = $task['to_message'];
                $row['Text']    = $task['body_message'];
                $row['Message_Type']    = $task['chatType']['title'];
                $row['Send_Status']  = $task['sendStatus']['title'];
                $row['Message_Status']  = $task['messageStatus']['title'];
                $row['Priority']  = $task['priority']['title'];
                $row['Send_date']  = date('d.m.Y H:i:s',strtotime($task['message_sent_at']));

                fputcsv($file, array($row['Client'], $row['Text'], $row['Message_Type'], $row['Send_Status'], $row['Message_Status'], $row['Priority'], $row['Send_date']));
            }
            mb_convert_encoding($file, 'UTF-16', 'UTF-8');
             fclose($file);
          };
            // ExportCSVFile(json_decode(json_encode($parcels), true));
            return response()->stream($callback, 200, $headers);
            exit();
    }
    
    
}
