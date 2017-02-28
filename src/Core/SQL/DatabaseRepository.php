<?php

namespace Softbox\Persistence\Core\SQL;


use Softbox\Persistence\Core\SQL\Command\SQLInsert;
use Softbox\Persistence\Core\SQL\Command\SQLUpdate;

/**
 * Implementacao de um repositorio de acesso a base de dados.
 *
 * @package Softbox\Persistence\Core
 */
class DatabaseRepository implements Repository {

    /**
     * @var PersistenceService
     */
    private $pserv;

    public function __construct() {
        $this->pserv = new PersistenceService();
    }

    /**
     * Retorna um comando SQL de SELECT.
     *
     * @param string $entity Nome da tabela.
     *
     * @return SQLSelect
     */
    public function query($entity) {
        return new SQLSelect($this->pserv, $entity);
    }

    /**
     * Retorna um comando de SQL INSERT para a entidade fornecida.
     *
     * @param $entity Nome da tabela o qual o registro sera inserido.
     *
     * @return SQLInsert
     */
    public function insert($entity) {
        return new SQLInsert($this->pserv, $entity);
    }

    /**
     * Retorna um comando de SQL UPDATE.
     *
     * @param $entiy Nome da tabela.
     *
     * @return SQLUpdate
     */
    public function update($entiy) {
        return new SQLUpdate($this->pserv, $entiy);
    }
}
