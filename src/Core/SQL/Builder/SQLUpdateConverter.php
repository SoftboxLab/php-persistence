<?php

namespace Softbox\Persistence\Core\SQL\Builder;

use Softbox\Persistence\Core\Converter;
use Softbox\Persistence\Core\Projection;
use Softbox\Persistence\Core\SQL\Command\SQLUpdate;

/**
 * Class used to create the SQL UPDATE command.
 */
class SQLUpdateConverter implements Converter
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * SQLUpdateConverter constructor.
     *
     * @param Converter $converter
     */
    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    private function buildWhere(Projection $select)
    {
        return $select->getFilter() === null ? "" : $this->converter->convert($select->getFilter());
    }

    public function convert($value)
    {
        if (!($value instanceof SQLUpdate)) {
            throw new SQLConverterException("Supply an instance of " . SQLUpdate::class . ".");
        }

        $cols   = array_keys($value->getTableValues());
        $params = array_map(function ($val) {
            return ":" . $val;
        }, $cols);

        return sprintf("UPDATE %s SET %s%s",
            $value->getEntity(),
            implode(", ", $params),
            $this->buildWhere($value->getFilter()));
    }
}
