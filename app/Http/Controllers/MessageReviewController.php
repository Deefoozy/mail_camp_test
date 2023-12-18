<?php

namespace App\Http\Controllers;

use App\Models\ProcessedMessage;

class MessageReviewController extends Controller
{
    // create parsing/encoding data table

    public function ShowList() {
        $messages = ProcessedMessage::all();

        return view('messageList', [
            'messages' => $messages,
        ]);
    }
}
