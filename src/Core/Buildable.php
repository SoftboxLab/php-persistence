<?php

namespace Softbox\Persistence\Core;

/**
 * Interface que sinaliza que o objeto pode ser convertido.
 *
 * @package Softbox\Persistence\Core
 */
interface Buildable {
    public function build(Converter $builder);
}