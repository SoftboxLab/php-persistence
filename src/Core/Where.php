<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 26/02/17
 * Time: 15:47
 */

namespace Softbox\Persistence\Core;

class Where implements Buildable {
    private $params = [];

    private $conditions = [];

    public function __construct() {
    }

    public function params() {

    }

    private function add($col, $op, $value = null) {
        $param = ":p_" . count($this->params);

        $this->params[$param] = $value;

        $this->conditions[] = new Condition($col, $op, $value === null ?  null : $param);
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

    public function addOR() {
        //$this->add($col, "=", $value);
    }

    public function getConditions() {
        return $this->conditions;
    }

    public function build(Builder $builder) {
        return $builder->build($this);
    }
}