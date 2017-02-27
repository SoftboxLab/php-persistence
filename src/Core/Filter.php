<?php


namespace Softbox\Persistence\Core;

class Filter implements Buildable {
    private $params = [];

    /**
     * @var Predicate
     */
    private $predicate = null;
    
    private $method = "setAnd";

    public function __construct() {
    }

    private function add($col, $op, $value = null) {
        $param = ":p_" . count($this->params);

        $this->params[$param] = $value;

        $condition = new Condition($col, $op, $value === null ?  null : $param);

        if ($this->predicate != null) {
            $method = $this->method;

            $condition->$method($this->predicate);
        }

        $this->predicate = $condition;
    }

    public function eq($col, $value = null) {
        $this->add($col, "=", $value);

        return $this;
    }

    public function neq($col, $value = null) {
        $this->add($col, "<>", $value);

        return $this;
    }

    public function gt($col, $value = null) {
        $this->add($col, ">", $value);

        return $this;
    }

    public function lt($col, $value = null) {
        $this->add($col, "<", $value);

        return $this;
    }

    public function ge($col, $value = null) {
        $this->add($col, ">=", $value);

        return $this;
    }

    public function le($col, $value = null) {
        $this->add($col, "<=", $value);

        return $this;
    }

    public function like($col, $value = null) {
        $this->add($col, "LIKE", $value);

        return $this;
    }

    public function nlike($col, $value = null) {
        $this->add($col, "NOT LIKE", $value);

        return $this;
    }

    public function isEmpty($col) {
        $this->add($col, "IS");

        return $this;
    }

    public function isNotEmpty($col) {
        $this->add($col, "IS NOT");

        return $this;
    }

    public function setAnd() {
        $this->method = "setAnd";

        return $this;
    }

    public function setOr() {
        $this->method = "setOr";

        return $this;
    }

    public function getPredicate() {
        return $this->predicate;
    }

    public function build(Builder $builder) {
        return $builder->build($this);
    }

    public function getParams() {
        return $this->params;
    }
}