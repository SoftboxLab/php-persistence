<?php

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\Command\NamedQuery;

abstract class NamedQueryBase implements NamedQuery {

    private $params = [];

    public function param($paramName, $value) {
        $this->params[$paramName] = $value;
    }
}