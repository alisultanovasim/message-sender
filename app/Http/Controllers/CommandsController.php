<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commands;
use App\CommandImages;
use App\CommandVideos;
use App\CommandAddress;
use App\CommandMessages;

use Auth;
use Cache;

class CommandsController extends Controller
{
    public function chatbot()
    {
        $command=Commands::where('company_id',Auth::user()->c_id)->first();
        $count=0;
        if($command)
        {
            $imagesCount=CommandImages::where('command_id',$command->id)->where('status','!=',2)->count();
            $videosCount=CommandVideos::where('command_id',$command->id)->where('status','!=',2)->count();
            $addressCount=CommandAddress::where('command_id',$command->id)->where('status','!=',2)->count();
            $messagesCount=CommandMessages::where('command_id',$command->id)->where('status','!=',2)->count();
            $count=$imagesCount+$videosCount+$addressCount+$messagesCount;
        }
        return view('messages.chatbot',compact('command','count'));
    }
    public function chatbotlist()
    {
        $command=Commands::with('images','messages','videos','addresses')->where('company_id',Auth::user()->c_id)->first();
        return view('messages.chatbotlist',compact('command'));
    }
    public function addcommands(Request $request)
    {
        $command=Commands::where('company_id',Auth::user()->id)->first();
        if(Auth::user()->c_id)
        {
            if($request['command_text']==null)
            {
                return back()->with(['status'=>'error','message'=>'Command daxil edilməyib']);
            }
            if($command)
            {
                Commands::where('id',$command->id)->update(['text'=>$request['command_text']]);
                $command_id=$command->id;
            }else
            {
                $command_id=Commands::insertGetId([
                    'text'=>$request['command_text'],
                    'company_id'=>Auth::user()->c_id
                    ]);
            }
            if(!empty($request['message'])>0)
            {
                for($i=0;$i<count($request['message']);$i++)
                {
                    CommandMessages::insert([
                        'title'=>$request['title'][$i],
                        'message'=>$request['message'][$i],
                        'command_id'=>$command_id
                        ]);
                }
            }
            if(!empty($request['image'])>0)
            {
                for($i=0;$i<count($request['image']);$i++)
                {
                    if ($request['image'][$i]) {
                        $image = \Storage::disk('public')->putFile('images', $request['image'][$i]);
                    }
                    CommandImages::insert([
                         'image'=>$image,
                         'caption'=>$request['image_name'][$i],
                         'command_id'=>$command_id
                        ]);
                }
            }
            if(!empty($request['video'])>0)
            {
                for($i=0;$i<count($request['video']);$i++)
                {
                    if ($request['video'][$i]) {
                        $video = \Storage::disk('public')->putFile('videos', $request['video'][$i]);
                    }
                    CommandVideos::insert([
                         'video'=>$video,
                         'caption'=>$request['video_name'][$i],
                         'command_id'=>$command_id
                        ]);
                }
            }
            if(!empty($request['address'])>0)
            {
                for($i=0;$i<count($request['address']);$i++)
                {
                    CommandAddress::insert([
                         'address'=>$request['address'][$i],
                         'latitude'=>$request['latitude'][$i],
                         'longitude'=>$request['longitude'][$i],
                         'command_id'=>$command_id
                        ]);
                }
            }
            return back()->with(['status'=>'success','message'=>'Əməliyyat uğurla yerinə yetirildi']);
        }else
        {
            return back()->with(['status'=>'error','message'=>'Şirkət hesabı aktiv deyil']);
        }
    }
}
