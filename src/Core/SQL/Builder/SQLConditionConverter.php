<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\Condition;

/**
 * Class used to create conditions that will be used on WHERE
 *
 * @package Softbox\Persistence\Core\SQL\Builder
 */
class SQLConditionConverter implements Converter {

    /**
     * @var Converter
     */
    private $converter;

    /**
     * SQLConditionConverter constructor.
     *
     * @param Converter $converter
     */
    public function __construct(Converter $converter) {
        $this->converter = $converter;
    }

    public function convert($value) {
        if (!($value instanceof Condition)) {
            throw new SQLConverterException("Supply an instance of " . Condition::class . ".");
        }

        $buffer = sprintf("%s %s %s",
            $this->converter->convert($value->getExpressionA()),
            $value->getOperator(),
            $this->converter->convert($value->getExpressionB()));

        if ($value->getAnd()) {
            $buffer .= " AND " . $this->converter->convert($value->getAnd());
        }
        if ($value->getOr()) {
            $buffer .= " OR " . $this->converter->convert($value->getOr());
        }

        return $buffer;
    }
}