<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        Mail::queue('email.send', ['title' => $title, 'content' => $content], function ($message) use ($attach)
        {
            $message->from('me@gmail.com', 'Christian Nwamba');
            $message->to('apple.xva@gmail.com');
        });

        return response()->json(['message' => 'Request completed']);
    }
}
