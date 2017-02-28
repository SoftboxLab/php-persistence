<?php

namespace Softbox\Persistence\Core;

class Order {
    const ASC  = "ASC";
    const DESC = "DESC";

    /**
     * @var array
     */
    private $orders = [];

    /**
     * Order constructor.
     */
    public function __construct() {
    }

    public final function asc($col) {
        $this->orders[] = $col . " " . static::ASC;

        return $this;
    }

    public final function desc($col) {
        $this->orders[] = $col . " " . static::DESC;

        return $this;
    }

    public final function arr() {
        return $this->orders;
    }

    public static final function create() {
        return new Order();
    }
}
