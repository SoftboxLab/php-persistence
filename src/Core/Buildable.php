<?php

namespace Softbox\Persistence\Core;

/**
 * Interface that shows that the object can be converted.
 */
interface Buildable
{
    public function build(Converter $builder);
}
