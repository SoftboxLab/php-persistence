<?php

namespace Softbox\Persistence\Core;

interface Buildable {
    public function build(Builder $builder);
}