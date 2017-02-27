<?php

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Condition;

class SQLCondition implements Buildable {

    private $builder;

    private $condition;

    public function __construct(Builder $builder, Condition $condition) {
        $this->builder = $builder;

        $this->condition = $condition;
    }

    public function build() {
        return $this->builder->build($this->condition->getExpressionA())
               . " " . $this->condition->getOperator() . " "
               . $this->builder->build($this->condition->getExpressionB());
    }
}