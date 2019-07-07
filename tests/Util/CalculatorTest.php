<?php
/**
 * Created by PhpStorm.
 * User: Banji
 * Date: 06/07/2019
 * Time: 17:27
 */

namespace App\Tests\Util;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $result = 30 + 12;

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}