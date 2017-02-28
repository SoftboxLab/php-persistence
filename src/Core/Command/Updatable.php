<?php

namespace Softbox\Persistence\Core\Command;

/**
 * Interface que representa um comando de atulizacao de registros.
 *
 * @package Softbox\Persistence\Core
 */
interface Updatable {

    /**
     * Configutra a quantidade maxima de registros a serem afetados pelo comando.
     *
     * @param $rowCount Numero maximo de registros a serem atualizadas.
     *
     * @return Updatable
     */
    public function limit($rowCount);

    /**
     * Condicao de filtro a ser aplicado na atualizacao.
     *
     * @param $filter Filtro.
     *
     * @return Updatable
     */
    public function filter(Filter $filter);

    /**
     * Configura o novo valor da coluna para atualizacao.
     *
     * @param string $col Nome da coluna do registro que sera atualizado.
     * @param $value Novo valor.
     *
     * @return Updatable
     */
    public function val($col, $value);

    /**
     * Realiza a execucao do comando.
     *
     * @return int Total de registros afetados.
     */
    public function execute();
}
