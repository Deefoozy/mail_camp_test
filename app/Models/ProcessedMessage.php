<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessedMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'parsed_result',
        'direction',
    ];

    static function parseMessage(string $input) {
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
                        if (is_numeric($char) && (int)$char >= 0) {
                            $indexedChar = $char;
                            $indexedCharCount++;
                        }
                        break;
    
                }
            };

            if ($indexedCharCount > 0) {
                $result .= ProcessedMessage::$parseKeys[$indexedChar]['std'][$indexedCharCount - 1];
            }
        };

        return new ProcessedMessage([
            'parsed_result' => $result,
            'direction' => 'raw_str',
        ]);
    }

    static function encodeMessage(string $input) {
        $parseKeyReferences = ProcessedMessage::generateEncodeKeyReferences();
        
        $result = '';

        $input = mb_strtolower($input);
        foreach(mb_str_split($input) as $index => $char) {
            if (!array_key_exists($char, $parseKeyReferences)) {
                continue;
            }

            $result .= str_repeat(
                $parseKeyReferences[$char]['key'],
                $parseKeyReferences[$char]['index'] + 1
            );

            if ($index < mb_strlen($input) - 1) {
                $result .= '.';
            }
        }

        return new ProcessedMessage([
            'parsed_result' => $result,
            'direction' => 'str_raw',
        ]);
    }

    static function generateEncodeKeyReferences() {
        $references = [];

        foreach(ProcessedMessage::$parseKeys as $key => $value) {
            foreach($value['std'] as $index => $char) {
                $references[$char] = [
                    'key' => $key,
                    'index' => $index,
                ];
            }
        }

        return $references;
    }

    private static $parseKeys = [
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
            'std' => ['#'],
            '*' => [],
            '**' => []
        ]
    ];
}
