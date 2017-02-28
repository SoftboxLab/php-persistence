<?php

namespace Softbox\Persistence\Core;

/**
 * Representa uma condicao de restricao qualquer. Exp A oprador Exp B.
 *
 * @package Softbox\Persistence\Core
 */
class Condition implements Predicate {

    /**
     * @var mixed
     */
    private $expressionA;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var mixed
     */
    private $expressionB;

    /**
     * @var Predicate
     */
    private $predicateAnd;

    /**
     * @var Predicate
     */
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

    public function build(Converter $builder) {
        return $builder->convert($this);
    }
}
