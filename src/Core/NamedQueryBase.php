<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 28/02/17
 * Time: 20:03
 */

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\Command\NamedQuery;

abstract class NamedQueryBase implements NamedQuery {
    private $params = [];

    public function param($paramName, $value) {
        $this->params[$paramName] = $value;
    }
}