<?php

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Builder;
use Softbox\Persistence\Core\Condition;
use Softbox\Persistence\Core\Where;

class SQLWhereBuilder implements Builder {
    private $builder;

    public function __construct(BUilder $builder) {
        $this->builder = $builder;
    }

    public function build($value) {
        if (!($value instanceof Where)) {
            throw new \BadMethodCallException("Supply a Where value.");
        }

        $buffer = "";

        $delim = " ";

        $cols = ["a" => true, "x" => true]; //$pserv

        /** @var Condition $condition */
        foreach ($value->getConditions() as $condition) {
            if (!isset($cols[$condition->getExpressionA()])) {
                continue;
            }

            $buffer .= $delim . $this->builder->build($condition);

            $delim = " AND ";
        }

        return "WHERE" . (empty($buffer) ? " 1 = 1" : $buffer);
    }
}