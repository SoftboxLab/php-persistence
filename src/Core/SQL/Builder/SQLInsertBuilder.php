<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 20:42
 */

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\SQL\Command\Insert;

class SQLInsertBuilder implements Builder {
    private $builder;

    public function __construct(Builder $builder) {
        $this->builder = $builder;
    }

    public function build($value) {
        if (!($value instanceof Insert)) {
            throw new \BadMethodCallException("Supply a Insert value.");
        }

        $cols = array_keys($value->getTableValues());

        $params = array_map(function($val) {
            return ":" . $val;
        }, $cols);

        return sprintf("INSERT INTO %s(%s) VALUES (%s)",
            $value->getEntity(),
            implode(", ", $cols),
            implode(", ", $params));
    }
}