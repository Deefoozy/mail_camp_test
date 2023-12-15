<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ParsedMessage;

class ParseController extends Controller
{
    // create parsing/encoding data table

    public function parse() {
        // Create validator

        // parse input

        // save input to database

        // return 200 with parsed result

        Response::json(
            [
                'message' => 'Hello world!',
            ],
            200
        );
    }

    public function encode() {
        // Create validator

        // encode input to numbers

        // save input to database

        // return 200 with parsed result
        Response::json(
            [
                'message' => 'Hello world!',
            ],
            200
        );
    }
}
