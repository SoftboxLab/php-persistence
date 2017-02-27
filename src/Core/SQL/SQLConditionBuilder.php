<?php

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Condition;

class SQLConditionBuilder implements Builder {
    private $builder;

    public function __construct(Builder $builder) {
        $this->builder = $builder;
    }

    public function build($value) {
        if (!($value instanceof Condition)) {
            throw new \BadMethodCallException("Supply a Condition value.");
        }

        return $this->builder->build($value->getExpressionA())
               . " " . $value->getOperator() . " "
               . $this->builder->build($value->getExpressionB());
    }
}