<?php

namespace Nijens\Range;

use InvalidArgumentException;

/**
 * Parses and generates ranges in Ruby syntax.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class Range
{
    /**
     * Regex used for parsing the range string.
     *
     * @var string
     */
    const REGEX = '#(\-?\d+(?:\.\d+)?)\.\.(\.?)(\-?\d+(?:\.\d+)?)#';

    /**
     * The from value of the range.
     *
     * @var int|float
     */
    private $from;

    /**
     * The to value of the range.
     *
     * @var int|float
     */
    private $to;

    /**
     * The boolean indicating if the value in the 'to' property is exclusive.
     *
     * @var bool
     */
    private $exclusive;

    /**
     * Constructs a new Range instance.
     *
     * @param int|float $from
     * @param int|float $to
     * @param bool      $exclusive
     */
    public function __construct($from, $to, $exclusive = false)
    {
        $this->from = $from;
        $this->to = $to;
        $this->exclusive = $exclusive;
    }

    /**
     * Returns the from value of the range.
     *
     * @return int|float
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Returns the (exclusive) to value of the range.
     *
     * @return int|float
     */
    public function getTo()
    {
        if ($this->getExclusive()) {
            $values = range($this->from, $this->to);
            array_pop($values);

            return end($values);
        }

        return $this->to;
    }

    /**
     * Returns the boolean indicating if the value in the 'to' property is exclusive.
     *
     * @return bool
     */
    public function getExclusive()
    {
        return $this->exclusive === true;
    }

    /**
     * Returns the Ruby syntax of this Range.
     *
     * @return string
     */
    public function __toString()
    {
        $range = strval($this->from);
        $range .= '..';
        if ($this->getExclusive()) {
            $range .= '.';
        }
        $range .= strval($this->to);

        return $range;
    }

    /**
     * Parses a range in Ruby syntax and returns a Range instance.
     *
     * @param string $range
     *
     * @return self
     */
    public static function parse($range)
    {
        $matches = array();

        if (preg_match(self::REGEX, $range, $matches) !== 1) {
            throw new InvalidArgumentException(sprintf('Provided range "%s" does not match Ruby syntax.', $range));
        }

        return new self($matches[1] + 0, $matches[3] + 0, $matches[2] === '.');
    }
}
