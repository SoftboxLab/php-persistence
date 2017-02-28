<?php

namespace Softbox\Persistence\Core\SQL\Command;

use Softbox\Persistence\Core\Buildable;
use Softbox\Persistence\Core\PersistenceService;
use Softbox\Persistence\Core\UpdateBase;

/**
 * Classe que representa o comando de UPDATE em banco de dados.
 *
 * @package Softbox\Persistence\Core\SQL\Command
 */
class SQLUpdate extends UpdateBase implements Buildable {

    /**
     * Servico de persistencia no banco de dados.
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
     * Retorna apenas os valores que pertencem a tabela.
     *
     * @return array [[Col => Novo valor] .. ]
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
    }
}