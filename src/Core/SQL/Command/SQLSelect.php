<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\Projection;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\PersistenceService;

/**
 * Class that represents the SQL SELECT command.
 */
class SQLSelect extends Projection implements Buildable
{
    /**
     * @var PersistenceService
     */
    private $persistence;

    /**
     * SQLSelect constructor.
     *
     * @param PersistenceService $persistence
     * @param $entity
     */
    public function __construct(PersistenceService $persistence, $entity)
    {
        parent::__construct($entity);
        $this->persistence = $persistence;
        $this->checkTable();
    }

    /**
     * Check if the given table exists.
     *
     * @throws SQLException
     */
    private function checkTable()
    {
        if (!$this->persistence->existsTable($this->getEntity())) {
            throw new SQLException("Table '" . $this->getEntity() . "' does not exists.'");
        }
    }

    private function getParams()
    {
        /** @var Filter $filter */
        $filter = $this->getFilter();

        return $filter ? $filter->getParams() : [];
    }

    public function projection(...$cols)
    {
        $tableCols = array_keys($this->persistence->getMetaData($this->getEntity()));
        if (count(array_intersect($tableCols, $cols)) != count($cols)) {
            throw new SQLException("There are invalid cols on projection.");
        }

        return parent::projection(...$cols);
    }

    public function order(...$orders)
    {
        $tableCols = array_keys($this->persistence->getMetaData($this->getEntity()));
        foreach ($orders as &$order) {
            $tokens = array_filter(explode(" ", $order));
            if (count($tokens) == 0 || count($tokens) > 2) {
                throw new SQLException("Invalid structure of order: $order.");
            }

            $col  = $tokens[0];
            $type = isset($tokens[1]) ? $tokens[1] : "ASC";

            if (!in_array(strtoupper($type), ["ASC", "DESC"])) {
                throw new SQLException("Invalid order.");
            }

            if (!in_array(strtolower($col), $tableCols)) {
                throw new SQLException("Invalid column supplied for order: $col");
            }

            $order = $col . " " . strtoupper($type);
        }

        return parent::order(...$orders);
    }

    public function execute()
    {
        $sql = $this->build(new SQLConverter());

        return $this->persistence->query($sql, $this->getParams());
    }
}
