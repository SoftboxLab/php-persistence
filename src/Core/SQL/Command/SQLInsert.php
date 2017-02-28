<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\InsertBase;
use Softbox\Persistence\Core\SQL\Builder\SQLConverter;
use Softbox\Persistence\Core\SQL\PersistenceService;

/**
 * Classe que representa o comando SQL de INSERT.
 *
 * @package Softbox\Persistence\Core\SQL\Command
 */
class SQLInsert extends InsertBase implements Buildable {

    /**
     * Servico de persistencia do banco de dados.
     *
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

    /**
     * Retorna um array com os valores possiveis de serem inseridos na base de dados.
     *
     * @return array [[Chave => Valor] ...]
     */
    public function getTableValues() {
        $cols = $this->pserv->getColsOfTable($this->getEntity());

        $values = [];

        foreach ($this->getValues() as $col => $val) {
            if (in_array($col, $cols)) {
                $values[$col] = $val;
            }
        }

        return $values;
    }

    public function execute() {
        $values = $this->getTableValues();

        if (empty($values)) {
            throw new SQLException("None value to be inserted.");
        }

        $sql = $this->build(new SQLConverter());

        return $this->pserv->exec($sql, $values);
    }
}
