<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.ticket.reply';
    const LANG_PATH = 'ticket.';

    public function store(Request $request)
    {
        $json = [];
        
        $validator = Validator::make($request->all(), [
            'body' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            $reply = new Reply();
            $reply->ticket_id = $request->ticket_id;
            $reply->author_id = $request->author_id;
            $reply->body = $request->body;
            $reply->save();
            
            if($request->media) {
                foreach ($request->media as $media) {
                    if(isset($media['src'])) {
                        $reply->addMedia(storage_path('app/' .$media['src']))->withResponsiveImages()->toMediaCollection(strpos($media['type'], 'image') === 0 ? 'images' : 'downloads');
                    }
                }
            }

            session()->flash('success', __(self::LANG_PATH . 'reply'));

            $json['success'] = true;
            $json['redirect'] = request()->server('HTTP_REFERER');
        }

        return response()->json($json, 200);

    }
}
