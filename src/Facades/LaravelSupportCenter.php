<?php

namespace LaravelSupportCenter\LaravelSupportCenter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelSupportCenter\LaravelSupportCenter\LaravelSupportCenter
 */
class LaravelSupportCenter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LaravelSupportCenter\LaravelSupportCenter\LaravelSupportCenter::class;
    }
}
