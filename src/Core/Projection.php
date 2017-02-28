<?php

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\Command\Queryable;

abstract class Projection implements Buildable, Queryable {

    private $cols;

    private $entity;

    private $filter = null;

    private $orderBy = null;

    private $offset = null;

    private $rowCount = null;

    public function __construct($entity, $cols = null) {
        $this->cols = $cols;
        $this->entity = $entity;
    }

    public function setFilter(Filter $filter) {
        $this->filter = $filter;

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
    public function getFilter() {
        return $this->filter;
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

    public function build(Converter $builder) {
        return $builder->convert($this);
    }

    /**
     * @param array ...$cols
     *
     * @return Queryable
     */
    public function projection(...$cols) {
        $this->cols = $cols;

        return $this;
    }

    /**
     * @param $filter
     *
     * @return Queryable
     */
    public function filter($filter) {
        $this->setFilter($filter);

        return $this;
    }

    /**
     * @param array ...$orders
     *
     * @return Queryable
     */
    public function order(...$orders) {
        $this->setOrderBy($orders);

        return $this;
    }

    /**
     * @return Queryable
     */
    public abstract function execute();
}
