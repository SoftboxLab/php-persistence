<?php

namespace Softbox\Persistence\Core;

class Condition implements Buildable {
    private $expressionA;

    private $operator;

    private $expressionB;

    public function __construct($expA, $operator, $expB) {
        $this->expressionA = $expA;
        $this->operator    = $operator;
        $this->expressionB = $expB;
    }

    public function getExpressionA() {
        return $this->expressionA;
    }

    public function getOperator() {
        return $this->operator;
    }

    public function getExpressionB() {
        return $this->expressionB;
    }

    public function build(Builder $builder) {
        return $builder->build($this);
    }
}
