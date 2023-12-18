<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ParsedMessage;
use App\Http\Requests\MessageParseRequest;
use App\Http\Requests\MessageEncodeRequest;
use PhpParser\Node\Expr\Cast\String_;

function parseMessage(string $input) {
    // search for nokia keyboard functionality
    // find correct file to put this in
    $keys = [
        '0' => [
            'std' => [' '],
            '*' => [],
            '**' => []
        ],
        '1' => [
            'std' => [''],
            '*' => [],
            '**' => []
        ],
        '2' => [
            'std' => ['a', 'b', 'c'],
            '*' => [],
            '**' => []
        ],
        '3' => [
            'std' => ['d', 'e', 'f'],
            '*' => [],
            '**' => []
        ],
        '4' => [
            'std' => ['g', 'h', 'i'],
            '*' => [],
            '**' => []
        ],
        '5' => [
            'std' => ['j', 'k', 'l'],
            '*' => [],
            '**' => []
        ],
        '6' => [
            'std' => ['m', 'n', 'o'],
            '*' => [],
            '**' => []
        ],
        '7' => [
            'std' => ['p', 'q', 'r', 's'],
            '*' => [],
            '**' => []
        ],
        '8' => [
            'std' => ['t', 'u', 'v'],
            '*' => [],
            '**' => []
        ],
        '9' => [
            'std' => ['w', 'x', 'y', 'z'],
            '*' => [],
            '**' => []
        ],
        '#' => [
            'std' => [' '],
            '*' => [],
            '**' => []
        ]
    ];

    $splitInputs = explode('.', $input);
    $result = '';

    foreach($splitInputs as $item) {
        $indexedChar = '';
        $indexedCharCount = 0;
        $specialCount = 0;

        foreach(mb_str_split($item) as $char) {
            switch ($char) {
                case '*':
                    $specialCount++;
                    break;
                default:
                    if (intval($char) >= 0) {
                        $indexedChar = $char;
                        $indexedCharCount++;
                    }
                    break;

            }
        };

        if ($indexedCharCount > 0) {
            $result .= $keys[$indexedChar]['std'][$indexedCharCount - 1];
        }
    };

    return $result;
}

class ParseController extends Controller
{
    // create parsing/encoding data table

    public function parse(MessageParseRequest $request) {
        // $testMsg = "7777.666.555.33.2";

        // Create validator
        $request->validated();

        // parse input
        $inputMessage = $request->input('message');

        $result = parseMessage($inputMessage);

        // save input to database

        // return 200 with parsed result
        return response()
            ->json([
                'message' => $result,
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
