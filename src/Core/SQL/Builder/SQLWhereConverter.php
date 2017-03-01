<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\Filter;

class SQLWhereConverter implements Converter
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * SQLWhereConverter constructor.
     *
     * @param Converter $converter
     */
    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    public function convert($value)
    {
        if (!($value instanceof Filter)) {
            throw new SQLConverterException("Supply an instance of " . Filter::class . ".");
        }

        $buffer = "";
        if ($value->getPredicate()) {
            $buffer = $this->converter->convert($value->getPredicate());
        }

        return " WHERE " . (empty($buffer) ? "1 = 1" : $buffer);
    }
}
