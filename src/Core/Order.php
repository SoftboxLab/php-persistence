<?php

namespace Softbox\Persistence\Core;

class Order
{
    const ASC  = "ASC";
    const DESC = "DESC";

    /**
     * @var array
     */
    private $orders = [];

    /**
     * Order constructor.
     */
    public function __construct()
    {
    }

    final public function asc($col)
    {
        $this->orders[] = $col . " " . static::ASC;

        return $this;
    }

    final public function desc($col)
    {
        $this->orders[] = $col . " " . static::DESC;

        return $this;
    }

    final public function arr()
    {
        return $this->orders;
    }

    final public static function create()
    {
        return new self();
    }
}
