<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Condition;
use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\InsertBase;
use Softbox\Persistence\Core\SQL\Command\SQLSelect;

/**
 * Class used to identify and delegate the building of SQL correct.
 */
class SQLConverter implements Converter
{
    /**
     * Builders of the SQL command.
     *
     * @var Converter[]
     */
    private $converters = [];

    /**
     * SQLConverter constructor.
     */
    public function __construct()
    {
        $this->converters = [
            Filter::class     => new SQLWhereConverter($this),
            Condition::class  => new SQLConditionConverter($this),
            SQLSelect::class  => new SQLSelectConverter($this),
            InsertBase::class => new SQLInsertConverter($this),
        ];
    }

    /**
     * Build the SQL command for the given value.
     *
     * @param mixed $value the value that will be converted
     *
     * @return string correspondent SQL to the given value
     */
    public function convert($value)
    {
        if ($value === null) {
            return "NULL";
        }

        if ($value instanceof Buildable) {
            $className = get_class($value);
            if (isset($this->converters[$className])) {
                return $this->converters[$className]->convert($value);
            }
        }

        return strval($value);
    }
}
