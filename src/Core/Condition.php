<?php

namespace Softbox\Persistence\Core;

class Condition implements Predicate {
    private $expressionA;

    private $operator;

    private $expressionB;

    private $predicateAnd;

    private $predicateOr;

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

    public function setAnd(Predicate $predicate) {
        $this->predicateAnd = $predicate;
    }

    public function setOr(Predicate $predicate) {
        $this->predicateOr = $predicate;
    }

    public function getAnd() {
        return $this->predicateAnd;
    }

    public function getOr() {
        return $this->predicateOr;
    }
}
