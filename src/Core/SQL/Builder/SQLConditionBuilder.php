<?php

namespace Softbox\Persistence\Core\SQL\Builder;

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

        $buffer = $this->builder->build($value->getExpressionA())
               . " " . $value->getOperator() . " "
               . $this->builder->build($value->getExpressionB());


        if ($value->getAnd()) {
            $buffer .= " AND " . $this->builder->build($value->getAnd());
        }

        if ($value->getOr()) {
            $buffer .= " OR " . $this->builder->build($value->getOr());
        }

        return $buffer;
    }
}