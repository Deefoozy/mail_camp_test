<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParsedMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'parsed_result',
        'direction',
    ];

    static function parseMessage(string $input) {
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

        return new ParsedMessage([
            'parsed_result' => $result,
            'direction' => 'raw_str',
        ]);
    }
}
