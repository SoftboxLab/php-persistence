<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 27/02/17
 * Time: 10:34
 */

namespace Softbox\Persistence\Core\SQL;

use Softbox\Persistence\Core\Where;

class Select {
    private $cols;

    private $entity;

    private $where = null;

    private $orderBy = null;

    private $offset = null;

    private $rowCount = null;

    public function __construct($entity, $cols = null) {
        $this->cols = $cols;
        $this->entity = $entity;
    }

    public function setWhere(Where $where) {
        $this->where = $where;

        return $this;
    }

    public function setOrderBy($order) {
        $this->orderBy = $order;

        return $this;
    }

    public function limit($offset, $rowCount) {
        $this->offset = $offset;
        $this->rowCount = $rowCount;

        return $this;
    }

    /**
     * @return null
     */
    public function getCols() {
        return $this->cols;
    }

    /**
     * @return mixed
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * @return null
     */
    public function getWhere() {
        return $this->where;
    }

    /**
     * @return null
     */
    public function getOrderBy() {
        return $this->orderBy;
    }

    /**
     * @return null
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * @return null
     */
    public function getRowCount() {
        return $this->rowCount;
    }
}