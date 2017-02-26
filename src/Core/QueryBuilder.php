<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 26/02/17
 * Time: 10:38
 */

namespace Softbox\Persistence\Core;

class QueryBuilder implements Queryable {
    private $entity;

    private $pserv;

    private $cols;

    private $where;

    public function __construct(PersistenceService $pserv, $entity) {
        $this->entity = $entity;
        $this->pserv = $pserv;
    }

    public function col(...$cols) {
        $entityCols = $this->pserv->getMetadata($this->entity);

        $this->cols = array_intersect($entityCols, array_map('strtolower', $cols));

        if (empty($this->cols)) {
            throw new \BadMethodCallException();
        }
    }

    public function where($where) {
        $this->where = $where;
    }

    public function order($orders) {
    }

    public function limit($offset, $rowCount) {
    }

    public function execute() {
        $sql = sprintf("SELECT %s FROM %s WHERE %s", implode(", ", $this->cols), $this->entity, $this->where->build());

        return $this->pserv->query($sql, $this->where->params());
    }
}