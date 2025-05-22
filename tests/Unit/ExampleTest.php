<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Generator;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    #[DataProvider('provideTrimData')]
    //public function testTrimTrimsLeadingSpace(string $expectedResult, string $input): void
    public function testTrimTrimsLeadingSpace(array $array): void
    {
        self::assertSame($array['expectedResult'], trim($array['input']));
    }

//    /**
//     * @return string[][]
//     */
//    public static function provideTrimData(): array
//    {
//        return [
//            'leading space is trimmed' => [
//                'Hello World',
//                ' Hello World'
//            ],
//            'trailing space and newline are trimmed' => [
//                'Hello World',
//                "Hello World \n"
//            ],
//            'space in the middle is removed' => [
//                'Hello World',
//                "\n Hello World \n"
//            ]
//        ];
//    }

    /**
     * @return Generator
     */
    public static function provideTrimData(): Generator
    {
        yield 'leading space is trimmed' => [
            [
               'expectedResult' => 'Hello World',
               'input' => ' Hello World'
            ]
        ];
        yield 'trailing space and newline are trimmed' => [
            [
                'expectedResult' => 'Hello World',
                'input' => " Hello World \n"
            ]
        ];
        yield 'space in the middle is removed' => [
            [
                'expectedResult' => 'Hello World',
                'input' => "\n Hello World \n"
            ]
        ];
    }
}
