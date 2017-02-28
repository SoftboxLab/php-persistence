<?php

namespace Softbox\Persistence\Core;

/**
 * Interface para implentacoes dos conversao de comandos.
 *
 * @package Softbox\Persistence\Core
 */
interface Converter {

    /**
     * Realiza a conversao do valor fornecido.
     *
     * @param $value Valor a ser convertido.
     *
     * @return mixed Valor convertido.
     */
    public function convert($value);
}
