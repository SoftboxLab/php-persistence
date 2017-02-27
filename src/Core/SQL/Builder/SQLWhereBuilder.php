<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Filter;

class SQLWhereBuilder implements Builder {
    private $builder;

    public function __construct(Builder $builder) {
        $this->builder = $builder;
    }

    public function build($value) {
        if (!($value instanceof Filter)) {
            throw new \BadMethodCallException("Supply a Where value.");
        }

        $buffer = "";

        if ($value->getPredicate()) {
            $buffer = $this->builder->build($value->getPredicate());
        }

        return "WHERE " . (empty($buffer) ? "1 = 1" : $buffer);
    }
}