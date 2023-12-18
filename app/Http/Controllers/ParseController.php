<?php

namespace App\Http\Controllers;

use App\Models\ProcessedMessage;
use App\Http\Requests\MessageParseRequest;
use App\Http\Requests\MessageEncodeRequest;

class ParseController extends Controller
{
    // create parsing/encoding data table

    public function parse(MessageParseRequest $request) {
        $request->validated();

        $inputMessage = $request->input('message');

        $parsedMessage = ProcessedMessage::parseMessage($inputMessage);
        $parsedMessage->save();

        return response()
            ->json([
                'message' => $parsedMessage->parsed_result,
            ], 200);
    }

    public function encode(MessageEncodeRequest $request) {
        $request->validated();

        $message = $request->input('message');

        $parsedMessage = ProcessedMessage::encodeMessage($message);
        $parsedMessage->save();

        return response()
            ->json([
                'message' => $parsedMessage->parsed_result,
            ], 200);
    }
}
