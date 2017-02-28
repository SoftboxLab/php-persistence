<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 28/02/17
 * Time: 20:02
 */

namespace Softbox\Persistence\Core\Command;


interface NamedQuery {

    /**
     * @param $paramName
     * @param $value
     *
     * @return NamedQuery
     */
    public function param($paramName, $value);

    /**
     * @return mixed
     */
    public function execute();
}