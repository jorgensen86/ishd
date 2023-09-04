<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Reply;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    const LAYOUT_PATH = 'layouts.admin.ticket.notification';
    const LANG_PATH = 'notification.';

    public function index($type, $id)
    {  
        if ($type === 'ticket') {
            $model = Ticket::find($id);
        } else {
            $model = Reply::find($id);
        }

        return view(self::LAYOUT_PATH . 'Form')
                ->with('title', __(self::LANG_PATH  . 'title'))
                ->with('text_add', __(self::LANG_PATH  . 'add'))
                ->with('action', route('notification.store'))
                ->with('relation', $model::class)
                ->with('model_id', $model->id)
                ->with('notifications', $model->notifications()->orderBy('created_at', 'asc')->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->relation === Ticket::class) {
            $model = Ticket::find($request->model_id);
        } else  {
            $model = Reply::find($request->model_id);
        }

        $validator = Validator::make($request->all(), [
            'body' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            $json = array(
                'title' => __('el.text_danger'),
                'errors' => $validator->getMessageBag()->toArray()
            );
        } else {
            $model->notifications()->save(new Notification([
                'author_id' => $request->author_id,
                'body' => $request->body,
            ]));
            
            $json = array(
                'title' => __('el.text_success'),
                'success' => __( 'notification.text_success'),
                'count' => $model->notifications()->count(),
                'id' => 'notif' . Str::replace('App\\Models\\', '', $request->relation) . $model->id
            );
        }

        
        return response()->json($json, 200);
    }

}
