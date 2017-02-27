<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\PersistenceService;
use Softbox\Persistence\Core\Projection;
use Softbox\Persistence\Core\ResultSet;
use Softbox\Persistence\Core\SQL\Builder\SQLBuilder;

class Select extends Projection implements Buildable {
    /**
     * @var PersistenceService
     */
    private $pserv;

    public function __construct(PersistenceService $pserv, $entity) {
        parent::__construct($entity);

        $this->pserv = $pserv;

        $this->checkTable();
    }

    /**
     * @return ResultSet
     */
    public function execute() {
        $sql = $this->build(new SQLBuilder());

        return $this->pserv->query($sql, $this->getParams());
    }

    private function getParams() {
        /** @var Filter $filter */
        $filter = $this->getFilter();

        return $filter ? $filter->getParams() : [];
    }

    public function projection(...$cols) {
        $tableCols = array_keys($this->pserv->getMetaData($this->getEntity()));

        if (count(array_intersect($tableCols, $cols)) != count($cols)) {
            throw new \BadMethodCallException("Invalide cols.");
        }

        return parent::projection(...$cols);
    }

    private function checkTable() {
        if (!$this->pserv->existsTable($this->getEntity())) {
            throw new \BadMethodCallException("Table '" . $this->getEntity() . "' does not exists.'");
        }
    }
}