<?php

namespace Nijens\Range\Tests;

use InvalidArgumentException;
use Nijens\Range\Range;
use PHPUnit_Framework_TestCase;

/**
 * RangeTest.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class RangeTest extends PHPUnit_Framework_TestCase
{
    /**
     * The Range instance used for testing.
     *
     * @var Range
     */
    private $range;

    /**
     * Constructs a Range instance for testing.
     */
    public function setUp()
    {
        $this->range = new Range(0, 1, false);
    }

    /**
     * Tests if the constructing a Range instance sets the instance properties.
     */
    public function testConstruct()
    {
        $this->assertAttributeSame(0, 'from', $this->range);
        $this->assertAttributeSame(1, 'to', $this->range);
        $this->assertAttributeSame(false, 'exclusive', $this->range);
    }

    /**
     * Tests if Range::getFrom returns the expected value.
     */
    public function testGetFrom()
    {
        $this->assertSame(0, $this->range->getFrom());
    }

    /**
     * Tests if Range::getTo returns the expected value.
     */
    public function testGetTo()
    {
        $this->assertSame(1, $this->range->getTo());
    }

    /**
     * Tests if Range::getTo returns the expected exclusive value.
     */
    public function testGetToExclusive()
    {
        $range = new Range(-1, 5, true);

        $this->assertSame(4, $range->getTo());
    }

    /**
     * Tests if Range::getExclusive returns the expected value.
     */
    public function testGetExclusive()
    {
        $this->assertFalse($this->range->getExclusive());
    }

    /**
     * Tests if the string representation of the Range is the expected Ruby syntax.
     */
    public function testToString()
    {
        $this->assertSame('0..1', strval($this->range));
    }

    /**
     * Tests if the string representation of the (exclusive) Range is the expected Ruby syntax.
     */
    public function testToStringExcusive()
    {
        $range = new Range(0, 1, true);

        $this->assertSame('0...1', strval($range));
    }

    /**
     * Tests if Range::parse returns a Range instance with expected values.
     *
     * @dataProvider provideRubyRangesForParsing
     *
     * @param string    $rangeInput
     * @param int|float $expectedFrom
     * @param int|float $expectedTo
     * @param bool      $expectedExclusive
     */
    public function testParse($rangeInput, $expectedFrom, $expectedTo, $expectedExclusive)
    {
        $range = Range::parse($rangeInput);

        $this->assertSame($expectedFrom, $range->getFrom());
        $this->assertSame($expectedTo, $range->getTo());
        $this->assertSame($expectedExclusive, $range->getExclusive());
    }

    /**
     * Tests if Range::parse throws an InvalidArgumentException for a range not in the Ruby range syntax.
     */
    public function testParseThrowsInvalidArgumentExceptionForInvalidRubyRangeSyntax()
    {
        $this->setExpectedException(InvalidArgumentException::class, '');

        Range::parse('invalid');
    }

    /**
     * Returns the array with test cases for @see testParse.
     *
     * @return array
     */
    public function provideRubyRangesForParsing()
    {
        return array(
            array('5...7', 5, 6, true),
            array('-1..6', -1, 6, false),
            array('1.0..6.0', 1.0, 6.0, false),
            array('1.0...6.0', 1.0, 5.0, true),
            array('6.0...1.0', 6.0, 2.0, true),
            array('1...-6', 1, -5, true),
            array('10..-60', 10, -60, false),
            array('10...-60', 10, -59, true),
            array('1.11..6.11', 1.11, 6.11, false),
        );
    }
}
