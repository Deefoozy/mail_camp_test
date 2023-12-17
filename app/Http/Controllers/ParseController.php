<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ParsedMessage;
use App\Http\Requests\MessageParseRequest;
use App\Http\Requests\MessageEncodeRequest;

class ParseController extends Controller
{
    // create parsing/encoding data table

    public function parse(MessageParseRequest $request) {
        // $testMsg = "7777.666.555.33.2";

        // Create validator
        $request->validated();

        // parse input
        $message = $request->input('message');

        // save input to database

        // return 200 with parsed result
        return response()
            ->json([
                'message' => $message,
            ], 200);
    }

    public function encode(MessageEncodeRequest $request) {
        // $testMsg = "hello world";

        // Create validator
        $request->validated();

        // encode input
        $message = $request->input('message');

        // save input to database

        // return 200 with parsed result
        return response()
            ->json([
                'message' => $message,
            ], 200);
    }
}
