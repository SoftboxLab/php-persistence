<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\Filter;
use Softbox\Persistence\Core\Projection;
use Softbox\Persistence\Core\ResultSet;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\PersistenceService;

/**
 * Classe que representa o comando SQL de SELECT.
 *
 * @package Softbox\Persistence\Core\SQL\Command
 */
class SQLSelect extends Projection implements Buildable {
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
     * Verifica se a tabela fornecida existe.
     *
     * @throws SQLException
     */
    private function checkTable() {
        if (!$this->pserv->existsTable($this->getEntity())) {
            throw new SQLException("Table '" . $this->getEntity() . "' does not exists.'");
        }
    }

    private function getParams() {
        /** @var Filter $filter */
        $filter = $this->getFilter();

        return $filter ? $filter->getParams() : [];
    }

    public function projection(...$cols) {
        $tableCols = array_keys($this->pserv->getMetaData($this->getEntity()));

        if (count(array_intersect($tableCols, $cols)) != count($cols)) {
            throw new SQLException("There is invalid cols on projection.");
        }

        return parent::projection(...$cols);
    }

    public function order(...$orders) {
        $tableCols = array_keys($this->pserv->getMetaData($this->getEntity()));

        foreach ($orders as &$order) {
            $tokens = array_filter(explode(" ", $order));

            if (count($tokens) == 0 || count($tokens) > 2) {
                throw new SQLException("Invalid strucuture of order: $order.");
            }

            $col = $tokens[0];

            $type = isset($tokens[1]) ? $tokens[1] : "ASC";

            if (!in_array(strtoupper($type), ["ASC", "DESC"])) {
                throw new SQLException("Invalide order.");
            }

            if (!in_array(strtolower($col), $tableCols)) {
                throw new SQLException("Invalide column supplied for order: $col");
            }

            $order = $col . " " . strtoupper($type);
        }

        return parent::order(...$orders);
    }

    /**
     * @return ResultSet
     */
    public function execute() {
        $sql = $this->build(new SQLConverter());

        return new ResultSet($this->pserv->query($sql, $this->getParams()));
    }
}
