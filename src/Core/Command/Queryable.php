<?php

namespace Softbox\Persistence\Core\Command;

/**
 * Interface that represents a sql command on repository.
 */
interface Queryable
{
    /**
     * @param array ...$cols
     *
     * @return Queryable
     */
    public function projection(...$cols);

    /**
     * @param $filter
     *
     * @return Queryable
     */
    public function filter($filter);

    /**
     * @param array ...$orders
     *
     * @return Queryable
     */
    public function order(...$orders);

    /**
     * @param $offset
     * @param $rowCount
     *
     * @return Queryable
     */
    public function limit($offset, $rowCount);

    /**
     * @return Queryable
     */
    public function execute();
}
