<?php

namespace Softbox\Persistence\Core\Command;

use Softbox\Persistence\Core\Filter;

/**
 * Interface that represents an update command
 *
 * @package Softbox\Persistence\Core
 */
interface Updatable {

    /**
     * Configure the max number of rows that will be affected
     *
     * @param int $rowCount the max number of rows that will be updated
     *
     * @return Updatable
     */
    public function limit($rowCount);

    /**
     * Define the filter that will be applied
     *
     * @param Filter $filter filter that will be applied
     *
     * @return Updatable
     */
    public function filter(Filter $filter);

    /**
     * Configure the new value for the column given
     *
     * @param string $col the name of column that will be updated
     * @param mixed $value the new value
     *
     * @return Updatable
     */
    public function val($col, $value);

    /**
     * Execute the command
     *
     * @return int number of affected rows
     */
    public function execute();
}
