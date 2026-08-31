<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use natilosir\bot\Database;

abstract class Model extends EloquentModel {
    public function __construct( array $attributes = [] ) {
        Database::boot();
        parent::__construct($attributes);
    }

    public function lg(): static {
        lg([
            'model' => static::class,
            'table' => $this->getTable(),
            'data'  => $this->attributesToArray(),
        ]);
        return $this;
    }

    public function log(): static {
        return $this->lg();
    }
}
