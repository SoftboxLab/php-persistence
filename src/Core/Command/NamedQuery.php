<?php

namespace Softbox\Persistence\Core\Command;

interface NamedQuery
{
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
