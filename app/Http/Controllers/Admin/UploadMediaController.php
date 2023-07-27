<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadMediaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    const FOLDER = 'temp/';

    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                // while (Storage::disk('local')->exists(SELF::FOLDER . auth()->user()->user_id . '/' . $request->file('file')->getClientOriginalName())) {
                    
                // }
                if(Storage::disk('local')->exists(SELF::FOLDER . auth()->user()->user_id . '/' . $request->file('file')->getClientOriginalName())) {
                    $filename = time() . '_' . $request->file('file')->getClientOriginalName();
                } else {
                    $filename = $request->file('file')->getClientOriginalName();
                }
                
                return Storage::putFileAs(SELF::FOLDER . auth()->user()->user_id, $request->file('file'),  $filename);
            }
        }
    }
}
