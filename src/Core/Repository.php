<?php
/**
 * Created by PhpStorm.
 * User: tarcisio
 * Date: 26/02/17
 * Time: 15:44
 */

namespace Softbox\Persistence\Core;

use Softbox\Persistence\Core\Command\Insertable;
use Softbox\Persistence\Core\Command\Queryable;
use Softbox\Persistence\Core\Command\Updatable;

/**
 * Interface que representa os comandos possiveis para um repositorio.
 *
 * @package Softbox\Persistence\Core
 */
interface Repository {

    /**
     * Retorna um comando de consulta para a entidade fornecida.
     *
     * @param string $entity Nome da entidade que sera consultada.
     *
     * @return Queryable
     */
    public function query($entity);

    /**
     * Retorna um comando de insert para a entidade fornecida.
     *
     * @param $entity Nome da entidade o qual o registro sera inserido.
     *
     * @return Insertable
     */
    public function insert($entity);

    /**
     * Retorna um comando de update para a entidade fornecida.
     *
     * @param $entity Nome da entidade o qual o registro sera inserido.
     *
     * @return Updatable
     */
    public function update($entiy);
}
