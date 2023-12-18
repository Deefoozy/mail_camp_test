<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\ProcessedMessage;

class MessageProcessingTest extends TestCase
{
    public function test_parsing(): void
    {
        $message = '55.33.777.7777';

        $result = ProcessedMessage::parseMessage($message);

        $this->assertTrue($result->parsed_result == 'kers');
    }

    public function test_parsing_with_space(): void
    {
        $message = '55.33.0.777.7777';

        $result = ProcessedMessage::parseMessage($message);

        $this->assertTrue($result->parsed_result == 'ke rs');
    }

    public function test_parsing_with_unexpected_character() {
        $message = '55.33./.777.7777';

        $result = ProcessedMessage::parseMessage($message);

        $this->assertTrue($result->parsed_result == 'kers');
    }

    public function test_encoding(): void
    {
        $message = 'silas';

        $result = ProcessedMessage::encodeMessage($message);

        $this->assertTrue($result->parsed_result == '7777.444.555.2.7777');
    }

    public function test_encoding_with_uppercase(): void
    {
        $message = 'Sileest';

        $result = ProcessedMessage::encodeMessage($message);

        $this->assertTrue($result->parsed_result == '7777.444.555.33.33.7777.8');
    }

    public function test_encoding_with_space(): void
    {
        $message = 'si los';

        $result = ProcessedMessage::encodeMessage($message);

        $this->assertTrue($result->parsed_result == '7777.444.0.555.666.7777');
    }

    public function test_encoding_with_unexpected_character(): void
    {
        $message = 'si/vast';

        $result = ProcessedMessage::encodeMessage($message);

        $this->assertTrue($result->parsed_result == '7777.444.888.2.7777.8');
    }
}
