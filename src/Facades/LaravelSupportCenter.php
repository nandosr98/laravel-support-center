<?php

namespace LaravelSupportCenter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelSupportCenter\LaravelSupportCenter
 */
class LaravelSupportCenter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LaravelSupportCenter\LaravelSupportCenter::class;
    }
}
