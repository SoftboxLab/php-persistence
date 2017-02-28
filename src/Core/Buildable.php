<?php

namespace Softbox\Persistence\Core;

/**
 * Interface that shows that the object can be converted.
 *
 * @package Softbox\Persistence\Core
 */
interface Buildable {
    public function build(Converter $builder);
}