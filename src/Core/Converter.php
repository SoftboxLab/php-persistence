<?php

namespace Softbox\Persistence\Core;

/**
 * Interface to implement the command conversions.
 *
 * @package Softbox\Persistence\Core
 */
interface Converter {

    /**
     * Converts the value given
     *
     * @param mixed $value Value to be converted
     *
     * @return mixed the value converted.
     */
    public function convert($value);
}
