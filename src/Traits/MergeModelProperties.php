<?php

namespace LaravelSupportCenter\Traits;


use Illuminate\Database\Eloquent\Model;

trait MergeModelProperties
{
    public function __construct(array $attributes = [])
    {
        if(is_callable('parent::__construct')) {
            parent::__construct($attributes);
        }

        $this->mergeParentModelProperties();
    }

    protected function mergeParentModelProperties(): void
    {
        $baseClass = get_parent_class($this);

        if (!$baseClass || !is_subclass_of($baseClass, Model::class)) {
            return;
        }

        $base = new $baseClass;

        $this->fillable = array_values(array_unique(array_merge(
            $base->getFillable(),
            $this->fillable
        )));

        $this->casts = array_merge(
            $base->getCasts(),
            $this->casts
        );
    }
}
